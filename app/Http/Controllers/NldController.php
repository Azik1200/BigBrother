<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Nld;
use App\Models\NldGroupStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NldExport;

class NldController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $user = auth()->user();
        $isAdmin = $user->isAdmin();

        $nldsQuery = Nld::with(['groups', 'doneStatuses.group'])
            ->when($request->filled('issue_key'), fn($q) =>
            $q->where('issue_key', 'like', "%{$request->issue_key}%"))
            ->when($request->filled('reporter_name'), fn($q) =>
            $q->where('reporter_name', 'like', "%{$request->reporter_name}%"))
            ->when($request->filled('issue_type'), fn($q) =>
            $q->where('issue_type', $request->issue_type))
            ->when($request->filled('group_id'), function ($q) use ($request) {
                if ($request->group_id === 'null') {
                    $q->whereDoesntHave('groups');
                } else {
                    $q->whereHas('groups', fn($query) =>
                    $query->where('groups.id', $request->group_id));
                }
            })
            ->when($request->filled('parent_issue_status'), fn($q) =>
            $q->where('parent_issue_status', 'like', "%{$request->parent_issue_status}%"));

        // Ограничения для обычных пользователей
        if (!$isAdmin) {
            $userGroupIds = $user->groups->pluck('id');
            $nldsQuery->whereHas('groups', fn($q) =>
            $q->whereIn('groups.id', $userGroupIds))
                ->whereDoesntHave('doneStatuses', function ($query) use ($userGroupIds) {
                    $query->whereIn('group_id', $userGroupIds);
                });
        }

        $nlds = $nldsQuery->orderByDesc('add_date')->get();

        // Ручная фильтрация по done
        if ($request->filled('done')) {
            $nlds = $nlds->filter(function ($nld) use ($request) {
                $groupIds = $nld->groups->pluck('id')->map(fn($id) => (int)$id)->sort()->values();
                $doneIds = $nld->doneStatuses->pluck('group_id')->map(fn($id) => (int)$id)->sort()->values();

                $isFullyDone = $groupIds->count() > 0 &&
                    $groupIds->diff($doneIds)->isEmpty() &&
                    $doneIds->diff($groupIds)->isEmpty();

                return $request->done == '1' ? $isFullyDone : !$isFullyDone;
            });
        }

        $page = $request->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $nlds->forPage($page, $perPage),
            $nlds->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $groups = Group::where('name', '!=', 'admin')->get();
        $parentStatuses = Nld::whereNotNull('parent_issue_status')
            ->where('parent_issue_status', '!=', '')
            ->distinct()
            ->pluck('parent_issue_status');
        $issueTypes = Nld::whereNotNull('issue_type')
            ->distinct()
            ->pluck('issue_type');

        return view('nld.index', [
            'nlds' => $paginated,
            'groups' => $groups,
            'parentStatuses' => $parentStatuses,
            'issueTypes' => $issueTypes,
        ]);
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
        $nld->load(['comments.user', 'groups', 'doneStatuses.group']);

        return view('nld.nld', compact('nld', 'comments'));
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
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'control_status' => 'nullable|string',
            'groups' => 'nullable|array',
            'groups.*' => 'exists:groups,id',
        ]);

        $oldGroupIds = $nld->groups()->pluck('groups.id')->toArray();
        $newGroupIds = $validated['groups'] ?? [];

        $nld->groups()->sync($newGroupIds);

        if (empty($oldGroupIds) && !empty($newGroupIds)) {
            $nld->control_status = 'In Progress';
        }

        $nld->update([
            'summary' => $validated['summary'] ?? $nld->summary,
            'description' => $validated['description'] ?? $nld->description,
            'control_status' => $nld->control_status, // уже обновлена при необходимости
        ]);

        return redirect()->route('nld.show', $nld)->with('success', 'NLD updated successfully.');
    }

    public function destroy(Nld $nld)
    {
        $nld->delete();

        return redirect()->route('nld.index')->with('success', 'NLD запись успешно удалена.');
    }

    public function done(Nld $nld)
    {
        $user = auth()->user();

        foreach ($user->groups as $group) {
            NldGroupStatus::updateOrCreate(
                ['nld_id' => $nld->id, 'group_id' => $group->id],
                ['done_at' => now()]
            );
        }

        return back()->with('success', 'Marked as finished for your group.');
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
            'send_date' => null,
        ];
    }

    public function unassign(Nld $nld)
    {
        $user = auth()->user();
        $userGroupIds = $user->groups->pluck('id')->toArray();

        $intersectingGroupIds = $nld->groups()
            ->whereIn('groups.id', $userGroupIds)
            ->pluck('groups.id')
            ->toArray();

        if (!empty($intersectingGroupIds)) {
            $nld->groups()->detach($intersectingGroupIds);

            return redirect()->route('nld.index')
                ->with('success', 'You have been unassigned from this NLD.');
        }

        return redirect()->route('nld.index')
            ->with('error', 'You are not assigned to this NLD.');
    }

    public function reopen(Request $request, Nld $nld)
    {
        $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        $nld->doneStatuses()
            ->where('group_id', $request->group_id)
            ->delete();

        return redirect()->route('nld.index')
            ->with('success', 'NLD has been marked as in progress again for the selected group.');
    }


    public function export(Request $request)
    {
        return Excel::download(new NldExport($request), 'nlds_filtered.xlsx');
    }

}
