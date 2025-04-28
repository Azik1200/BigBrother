<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::whereNull('deleted_at')->get();

        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        $users = User::all();

        return view('groups.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'group_leader' => ['required', 'exists:users,id'],
        ]);

        $group = Group::create([
            'name' => $validated['name'],
            'user_id' => Auth::id(),
            'group_leader' => $validated['group_leader'],
        ]);

        $group->users()->attach($validated['group_leader']);

        return redirect()->route('group')->with('success', 'Группа успешно создана!');
    }

    public function delete(Group $group)
    {
        $group->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);

        return redirect()->route('group')->with('success', 'Группа успешно удалена!');
    }

    public function show(Group $group)
    {
        $membersCount = $group->members()->count();

        return view('groups.show', compact('group', 'membersCount'));
    }

    public function addMembersForm(Group $group)
    {
        $users = User::whereDoesntHave('groups', function ($query) use ($group) {
            $query->where('groups.id', $group->id);
        })->get();

        return view('groups.add_members', compact('group', 'users'));
    }

    public function addMembers(Request $request, Group $group)
    {
        $validated = $request->validate([
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['exists:users,id'],
        ]);

        $group->members()->attach($validated['user_ids']);

        return redirect()->route('group.show', $group->id)
            ->with('success', 'Новые участники успешно добавлены в группу!');
    }

    public function removeMember(Group $group, User $user)
    {
        if ($group->group_leader == $user->id && !Auth::user()->isAdmin()) {
            return redirect()->route('group.show', $group->id)
                ->with('error', 'Только администратор может удалить руководителя группы!');
        }

        $group->members()->detach($user->id);

        return redirect()->route('group.show', $group->id)
            ->with('success', 'Участник успешно удалён из группы!');
    }

    public function myGroups()
    {
        $groups = Auth::user()->groups;

        return view('groups.my_group', compact('groups'));
    }
}
