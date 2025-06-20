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
        $user = Auth::user();
        $groupIds = $user->groups->pluck('id');

        $assignedTasks = $user->assignedTasks;
        $createdTasks = $user->createdTasks ?? Task::where('user_id', $user->id)->get();
        $unassignedTasks = Task::whereHas('groups', fn($q) => $q->whereIn('groups.id', $groupIds))
            ->whereDoesntHave('assignees')
            ->get();

        return view('tasks.index', compact('assignedTasks', 'createdTasks', 'unassignedTasks'));
    }

    public function create()
    {
        $groups = Auth::user()->groups()->with('leader')->get();
        $users = User::all();

        return view('tasks.create', compact('groups', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:3', 'max:1000'],
            'group_ids' => ['required', 'array'],
            'group_ids.*' => ['exists:groups,id'],
            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed'],
            'due_date' => ['required', 'date', 'after:today'],
            'assigned_users' => ['nullable', 'array'],
            'assigned_users.*' => ['exists:users,id'],
        ]);

        $task = Task::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'],
            'user_id' => Auth::id(),
        ]);

        $task->groups()->attach($validated['group_ids']);

        if (!empty($validated['assigned_users'])) {
            $allowedUsers = User::whereIn('id', $validated['assigned_users'])
                ->where('group_leader', false)
                ->pluck('id')
                ->toArray();

            $task->assignees()->attach($allowedUsers);
        }

        $groupLeader = User::where('group_leader', true)->first();
        if ($groupLeader) {
            $task->update(['review_by' => $groupLeader->id]);
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

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана.');
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $task->update($validated);

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
            return back()->with('success', 'Задача успешно назначена на вас.');
        }

        return back()->with('warning', 'Вы уже назначены на эту задачу.');
    }

    public function unassignFromMe(Task $task)
    {
        $user = Auth::user();

        if ($task->assignees->contains($user->id)) {
            $task->assignees()->detach($user->id);
            return back()->with('success', 'Вы сняли задачу с себя.');
        }

        return back()->with('warning', 'Вы не назначены на эту задачу.');
    }
}
