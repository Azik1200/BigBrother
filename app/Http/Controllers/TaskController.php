<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $groups = $user->groups;

        $assignedTasks = $user->assignedTasks;
        $createdTasks = Task::where('user_id', $user->id)->get();
        $groupIds = $groups->pluck('id');

        $unassignedTasks = Task::whereHas('groups', function ($query) use ($groupIds) {
            $query->whereIn('groups.id', $groupIds);
        })
            ->whereDoesntHave('assignees')
            ->get();

        return view('tasks.index', compact('assignedTasks', 'createdTasks', 'unassignedTasks'));
    }

    public function create()
    {
        $groups = auth()->user()->groups()->with('leader')->get();


        $users = User::all();

        return view('tasks.create', compact('groups', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:1000',
            'group_ids' => 'required|array',
            'group_ids.*' => 'exists:groups,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date|after:today',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => auth()->id(),
        ]);

        $task->groups()->attach($request->group_ids);

        if ($request->has('assigned_users')) {
            $allowedUsers = User::whereIn('id', $request->assigned_users)
                ->where('group_leader', 0)
                ->pluck('id')->toArray();

            $task->users()->attach($allowedUsers);
        }

        $groupLeader = User::where('group_leader', 1)->first();
        if ($groupLeader) {
            $task->review_by = $groupLeader->id;
            $task->save();
        }

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = $file->store('tasks/files', 'public');
                $task->files()->create([
                    'path' => $filePath,
                    'name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('tasks')->with('success', 'Задача успешно создана.');
    }

    public function show(Task $task)
    {
        $task->load('comments.user');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->only('name', 'description', 'is_completed'));

        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }

    public function assignToMe(Task $task)
    {
        $user = Auth::user();

        if (!$task->assignees->contains($user->id)) {
            $task->assignees()->attach($user->id);
            return redirect()->back()->with('success', 'Задача успешно назначена на вас.');
        }

        return redirect()->back()->with('warning', 'Задача уже назначена на вас.');
    }

    public function unassignFromMe(Task $task)
    {
        $user = Auth::user();

        if ($task->assignees->contains($user->id)) {
            $task->assignees()->detach($user->id);
            return redirect()->back()->with('success', 'Вы сняли задачу с себя.');
        }

        return redirect()->back()->with('warning', 'Вы не назначены на эту задачу.');
    }

}
