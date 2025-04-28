<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScriptController extends Controller
{
    public function index()
    {
        $scripts = Script::all();
        $groups = Group::all();

        return view('scripts.index', compact('scripts', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'group_id' => ['nullable', 'exists:groups,id'],
        ]);

        Script::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
            'group_id' => $validated['group_id'] ?? null,
            'author_id' => Auth::id(),
        ]);

        return redirect()->route('scripts.index')->with('success', 'Скрипт успешно добавлен!');
    }
}
