<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Script;
use Illuminate\Http\Request;

class ScriptController extends Controller
{
    public function index()
    {
        $scripts = Script::all();
        $groups = Group::all();

        return view('scripts.index', compact('scripts', 'groups'));
    }

    //TODO Доработать скрипт
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        Script::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'group_id' => $validated['group_id'] ?? null,
            'author_id' => auth()->id(), // Добавляем текущего пользователя как автора
        ]);

        return redirect()->route('scripts.index')->with('success', 'Скрипт успешно добавлен!');
    }
}
