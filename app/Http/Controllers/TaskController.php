<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|min:3|max:255',
            'description'=> 'nullable|min:3|max:1000',
        ]);

        Task::create($request->only('name', 'description'));

        return redirect()->route('tasks.index')->with('success', 'Nice');
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
