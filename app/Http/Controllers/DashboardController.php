<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $groups = $user->groups;

        $assignedTasks = $user->assignedTasks;

        $createdTasks = Task::where('user_id', $user->id)->get();

        $groupIds = $groups->pluck('id'); // ID групп пользователя
        $groupTasksNoAssignee = Task::whereIn('group_id', $groupIds)
            ->whereDoesntHave('assignees') // Если нет исполнителей
            ->get();

        return view('dashboard.index', compact('user', 'groups', 'assignedTasks', 'createdTasks', 'groupTasksNoAssignee'));
    }

}
