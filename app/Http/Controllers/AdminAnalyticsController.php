<?php

namespace App\Http\Controllers;

use App\Models\Nld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $query = Nld::where('parent_issue_status', 'Done');

        $total = (clone $query)->count();
        $done = (clone $query)->whereNotNull('done_date')->count();
        $inProgress = (clone $query)->whereNull('done_date')->count();

        $byType = (clone $query)
            ->select('issue_type', DB::raw('count(*) as count'))
            ->groupBy('issue_type')
            ->pluck('count', 'issue_type');

        $byGroup = (clone $query)
            ->with('group')
            ->get()
            ->groupBy(fn($nld) => $nld->group->name ?? 'No Group')
            ->map(fn($items) => $items->count());

        $groupDetails = (clone $query)
            ->with('group')
            ->get()
            ->groupBy(fn($nld) => $nld->group->name ?? 'No Group')
            ->map(function ($items) {
                return [
                    'done' => $items->whereNotNull('done_date'),
                    'in_progress' => $items->whereNull('done_date'),
                ];
            });

        return view('admin.analytics', compact('total', 'done', 'inProgress', 'byType', 'byGroup', 'groupDetails'));
    }


}
