<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Nld;
use App\Models\NldGroupStatus;
use App\Services\NldImportService;
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
            ->when($request->filled('parent_issue_status'), function ($q) use ($request) {
                $statuses = $request->input('parent_issue_status');
                $statuses = is_array($statuses) ? array_filter($statuses) : [$statuses];
                if (!empty($statuses)) {
                    $q->whereIn('parent_issue_status', $statuses);
                }
            });

        if (!$isAdmin) {
            $userGroupIds = $user->groups->pluck('id');

            $nldsQuery->whereHas('groups', fn($q) =>
            $q->whereIn('groups.id', $userGroupIds));
        }

        if ($request->filled('done')) {
            $isDoneFilter = $request->get('done') == '1';

            $nldsQuery->where('control_status', $isDoneFilter ? 'Done' : 'In Progress');
        }

        $nlds = $nldsQuery->orderByDesc('add_date')->get();

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

    public function store(Request $request, NldImportService $importService)
    {
        $validated = $request->validate([
            'nld_file' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ]);

        try {
            $importService->importFromFile($validated['nld_file']);

            return redirect()->route('nld.index')->with('success', 'Данные из Excel успешно импортированы.');
        } catch (\Exception $e) {
            Log::error('Ошибка обработки Excel: ' . $e->getMessage());
            return back()->with('error', $e->getMessage());
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
            'parent_issue_status' => 'nullable|string',
            'group_ids' => 'nullable|array',
            'group_ids.*' => 'exists:groups,id',
        ]);

        $newGroupIds = $validated['group_ids'] ?? [];

        $oldGroupIds = $nld->groups()->pluck('groups.id')->toArray();

        $nld->groups()->sync($newGroupIds);

        if (empty($oldGroupIds) && !empty($newGroupIds)) {
            $nld->control_status = 'In Progress';
        }

        $nld->summary = $validated['summary'] ?? $nld->summary;
        $nld->description = $validated['description'] ?? $nld->description;
        $nld->parent_issue_status = $validated['parent_issue_status'] ?? $nld->parent_issue_status;

        $nld->save();

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

        $assignedGroupIds = $nld->groups->pluck('id')->sort()->values();

        $doneGroupIds = $nld->doneStatuses
            ->whereNotNull('done_at')
            ->pluck('group_id')
            ->sort()
            ->values();

        if ($assignedGroupIds->isNotEmpty() && $assignedGroupIds->toArray() === $doneGroupIds->toArray()) {
            $nld->update([
                'control_status' => 'Done',
            ]);
        }

        return back()->with('success', 'Your group marked this task as finished.');
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

            if ($nld->groups()->count() === 0) {
                $nld->update(['control_status' => 'To Do']);
            }

            return redirect()->route('nld.index')
                ->with('success', 'You have been unassigned from this NLD.');
        }

        return redirect()->route('nld.index')
            ->with('error', 'You are not assigned to this NLD.');
    }


    public function reopen(Request $request, Nld $nld)
    {
        $validated = $request->validate([
            'group_id' => ['required', 'exists:groups,id'],
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        $nld->doneStatuses()
            ->where('group_id', $validated['group_id'])
            ->delete();

        $nld->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $validated['comment'],
        ]);

        $nld->control_status = 'In Progress';
        $nld->save();

        return redirect()->route('nld.index')
            ->with('success', 'NLD has been marked as in progress again for the selected group.');
    }




    public function export(Request $request)
    {
        return Excel::download(new NldExport($request), 'nlds_filtered.xlsx');
    }

}
