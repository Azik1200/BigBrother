<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $roles = $user->roles;
        $groups = $user->groups;

        $assignedTasks = $user->assignedTasks;

        $createdTasks = Task::where('user_id', $user->id)->get();

        $groupIds = $groups->pluck('id');
        $groupTasksNoAssignee = Task::whereHas('groups', function ($query) use ($groupIds) {
            $query->whereIn('groups.id', $groupIds);
        })
            ->whereDoesntHave('assignees') // Если нет исполнителей
            ->get();

        return view('dashboard.index', compact('user', 'groups', 'assignedTasks', 'createdTasks', 'groupTasksNoAssignee','roles'));
    }

}
