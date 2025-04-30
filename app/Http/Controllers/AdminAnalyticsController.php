<?php

namespace App\Http\Controllers;

use App\Models\Nld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        $total = Nld::count();
        $done = Nld::whereNotNull('done_date')->count();
        $inProgress = Nld::whereNull('done_date')->count();

        $byType = Nld::select('issue_type', DB::raw('count(*) as count'))
            ->groupBy('issue_type')
            ->pluck('count', 'issue_type');

        $byGroup = Nld::with('group')
            ->get()
            ->groupBy(fn($nld) => $nld->group->name ?? 'No Group')
            ->map(fn($items) => $items->count());

        return view('admin.analytics', compact('total', 'done', 'inProgress', 'byType', 'byGroup'));
    }
}
