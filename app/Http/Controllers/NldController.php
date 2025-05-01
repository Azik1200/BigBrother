<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Nld;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NldExport;

class NldController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $nlds = Nld::query()
            ->when($request->filled('issue_key'), fn($q) => $q->where('issue_key', 'like', "%{$request->issue_key}%"))
            ->when($request->filled('reporter_name'), fn($q) => $q->where('reporter_name', 'like', "%{$request->reporter_name}%"))
            ->when($request->filled('issue_type'), fn($q) => $q->where('issue_type', $request->issue_type))
            ->when($request->filled('group_id'), function ($q) use ($request) {
                if ($request->group_id === 'null') {
                    $q->whereDoesntHave('groups');
                } else {
                    $q->whereHas('groups', fn($query) => $query->where('groups.id', $request->group_id));
                }
            })
            ->when($request->filled('done'), function ($q) use ($request) {
                if ($request->done == '1') {
                    $q->whereNotNull('done_date');
                } elseif ($request->done == '0') {
                    $q->whereNull('done_date');
                }
            })
            ->when($request->filled('parent_issue_status'), fn($q) =>
            $q->where('parent_issue_status', 'like', "%{$request->parent_issue_status}%"))
            ->orderByDesc('add_date')
            ->paginate($perPage)
            ->appends($request->query());

        $groups = Group::all();
        $parentStatuses = Nld::select('parent_issue_status')
            ->whereNotNull('parent_issue_status')
            ->distinct()
            ->pluck('parent_issue_status');
        $issueTypes = Nld::select('issue_type')
            ->whereNotNull('issue_type')
            ->distinct()
            ->pluck('issue_type');

        return view('nld.index', compact('nlds', 'groups', 'parentStatuses', 'issueTypes'));
    }


    public function create()
    {
        return view('nld.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nld_file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ]);

        try {
            $excelData = Excel::toArray(new class() implements \Maatwebsite\Excel\Concerns\ToArray {
                public function array(array $rows) { return $rows; }
            }, $validated['nld_file']);

            $rows = $excelData[0] ?? [];

            if (count($rows) <= 1) {
                return back()->with('error', 'Excel файл не содержит данных.');
            }

            foreach (array_slice($rows, 1) as $row) {
                $nldData = $this->mapRowToNldData($row);

                try {
                    Nld::create($nldData);
                } catch (\Exception $e) {
                    Log::error('Ошибка сохранения NLD: ' . $e->getMessage(), $nldData);
                    return back()->with('error', 'Ошибка при сохранении данных.');
                }
            }

            return redirect()->route('nld')->with('success', 'Данные из Excel успешно импортированы.');
        } catch (\Exception $e) {
            Log::error('Ошибка обработки Excel: ' . $e->getMessage());
            return back()->with('error', 'Ошибка при обработке Excel файла.');
        }
    }

    public function show(Nld $nld)
    {
        $comments = $nld->comments;
        $doneDate = $nld->done_date;

        return view('nld.nld', compact('nld', 'comments', 'doneDate'));
    }

    public function edit(Nld $nld)
    {
        $groups = Group::select('id', 'name')->get();
        $selectedGroupIds = $nld->groups()->pluck('group_id')->toArray();

        return view('nld.edit', compact('nld', 'groups', 'selectedGroupIds'));
    }

    public function update(Request $request, Nld $nld)
    {
        $validated = $request->validate([
            'group_ids' => ['nullable', 'array'],
            'group_ids.*' => ['integer', 'exists:groups,id'],
            'parent_issue_status' => ['nullable', 'string', 'max:255'],
        ]);

        if (!empty($validated['parent_issue_status'])) {
            $nld->parent_issue_status = $validated['parent_issue_status'];
        }

        $nld->save();

        if (isset($validated['group_ids'])) {
            $nld->groups()->sync($validated['group_ids']);
            $nld->send_date = now()->format('Y-m-d');
            $nld->save();
        }

        return redirect()->route('nld.index')->with('success', 'NLD record successfully updated.');
    }

    public function destroy(Nld $nld)
    {
        $nld->delete();

        return redirect()->route('nld.index')->with('success', 'NLD запись успешно удалена.');
    }

    public function done(Nld $nld)
    {
        $nld->update([
            'done_date' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('nld.index');
    }

    /**
     * Helper: Карта строки Excel в данные для создания NLD.
     */
    private function mapRowToNldData(array $row): array
    {
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        $createdDate = is_numeric($row[6] ?? null)
            ? $baseDate->copy()->addDays($row[6] - 2)->format('Y-m-d')
            : now()->format('Y-m-d');

        $updatedDate = is_numeric($row[5] ?? null)
            ? $baseDate->copy()->addDays($row[5] - 2)->format('Y-m-d')
            : now()->format('Y-m-d');

        return [
            'issue_key' => $row[0] ?? null,
            'summary' => isset($row[1]) ? str_replace('_x000D_', "\n", $row[1]) : '',
            'description' => isset($row[2]) ? str_replace('_x000D_', "\n", $row[2]) : '-',
            'reporter_name' => $row[3] ?? '',
            'issue_type' => $row[4] ?? '',
            'updated' => $updatedDate,
            'created' => $createdDate,
            'parent_issue_key' => $row[7] ?? '',
            'parent_issue_status' => isset($row[8]) ? str_replace('_x000D_', "\n", $row[8]) : '',
            'parent_issue_number' => $row[9] ?? '',
            'control_status' => 'To Do',
            'add_date' => now()->format('Y-m-d'),
            'send_date' => now()->format('Y-m-d'),
            'done_date' => null,
        ];
    }

    public function unassign(Nld $nld)
    {
        if (auth()->user()->groups->contains('id', $nld->group_id)) {
            $nld->update(['group_id' => null]);
            return redirect()->route('nld.index')->with('success', 'You have been unassigned from this NLD.');
        }

        return redirect()->route('nld.index')->with('error', 'You are not assigned to this NLD.');
    }

    public function reopen(Nld $nld)
    {
        if ($nld->done_date) {
            $nld->update(['done_date' => null]);
            return redirect()->route('nld.index')->with('success', 'NLD marked as In Progress again.');
        }

        return redirect()->route('nld.index')->with('info', 'NLD is already in progress.');
    }

    public function export(Request $request)
    {
        return Excel::download(new NldExport($request), 'nlds_filtered.xlsx');
    }

}
