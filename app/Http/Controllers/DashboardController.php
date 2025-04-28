<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $roles = $user->roles;
        $groups = $user->groups;
        $assignedTasks = $user->assignedTasks;
        $createdTasks = $user->createdTasks ?? Task::where('user_id', $user->id)->get(); // fallback если нет связи
        $groupIds = $groups->pluck('id');

        $groupTasksNoAssignee = Task::whereHas('groups', function ($query) use ($groupIds) {
            $query->whereIn('groups.id', $groupIds);
        })->whereDoesntHave('assignees')->get();

        return view('dashboard.index', [
            'user' => $user,
            'groups' => $groups,
            'roles' => $roles,
            'assignedTasks' => $assignedTasks,
            'createdTasks' => $createdTasks,
            'groupTasksNoAssignee' => $groupTasksNoAssignee,
        ]);
    }
}
