<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $groups = Group::all();
        return view('groups.create', compact('groups'));
    }

    // Сохранение новой группы
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create([
            'name' => $request->input('name'),
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('group')->with('success', 'Группа успешно создана!');
    }
}

