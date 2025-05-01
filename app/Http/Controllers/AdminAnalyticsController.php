<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Nld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $nlds = Nld::with(['groups', 'doneStatuses.group'])
            ->where('parent_issue_status', 'Done')
            ->get();

        $total = $nlds->count();

        $done = $nlds->filter(function ($nld) {
            $groupIds = $nld->groups->pluck('id')->sort()->values()->toArray();
            $doneIds = $nld->doneStatuses->pluck('group_id')->sort()->values()->toArray();
            return !empty($groupIds) && $groupIds === $doneIds;
        })->count();

        $inProgress = $total - $done;

        $byType = $nlds->groupBy('issue_type')
            ->map(fn($items) => $items->count());

        $groupDetails = [];
        $groups = Group::where('name', '!=', 'admin')->get();

        foreach ($groups as $group) {
            $tasks = $nlds->filter(fn($nld) => $nld->groups->contains('id', $group->id));

            $groupDetails[$group->name] = [
                'done' => $tasks->filter(fn($nld) => $nld->doneStatuses->contains('group_id', $group->id)),
                'in_progress' => $tasks->reject(fn($nld) => $nld->doneStatuses->contains('group_id', $group->id)),
            ];
        }

        $byGroup = $nlds->flatMap(fn($nld) => $nld->groups->pluck('name'))
            ->filter()
            ->countBy();

        return view('admin.analytics', compact('total', 'done', 'inProgress', 'byType', 'byGroup', 'groupDetails'));
    }
}
