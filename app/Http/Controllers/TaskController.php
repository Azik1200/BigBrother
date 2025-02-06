<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $groups = $user->groups;

        $assignedTasks = $user->assignedTasks;
        $createdTasks = Task::where('user_id', $user->id)->get();
        $groupIds = $groups->pluck('id');
        $unassignedTasks = Task::whereIn('group_id', $groupIds)
            ->whereDoesntHave('assignees')
            ->get();

        return view('tasks.index', compact('assignedTasks', 'createdTasks', 'unassignedTasks'));
    }

    public function create()
    {
        $groups = auth()->user()->groups;
        return view('tasks.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:1000',
            'group_id' => 'required|exists:groups,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date|after:today',
        ]);

        Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'group_id' => $request->group_id,
            'priority' => $request->priority,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    // Форма редактирования задачи
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Обновить задачу
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task->update($request->only('name', 'description', 'is_completed'));

        return redirect()->route('tasks.index')->with('success', 'Задача успешно обновлена!');
    }

    // Удалить задачу
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задача успешно удалена!');
    }

}
