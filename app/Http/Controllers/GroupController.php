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
        $groups = Group::where('deleted_at', null)->get();
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Group::create([
            'name' => $request->input('name'),
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('group')->with('success', 'Группа успешно создана!');
    }

    public function delete(Group $group)
    {
        $user = auth()->user();

        $group->update([
            'deleted_at' => now(),
            'deleted_by' => $user->id,
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
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $group->members()->attach($request->user_ids);

        return redirect()->route('group.show', $group->id)
            ->with('success', 'Новые участники успешно добавлены в группу!');
    }

    public function removeMember(Group $group, User $user)
    {

        $group->members()->detach($user->id);

        return redirect()->route('group.show', $group->id)
            ->with('success', 'Участник успешно удалён из группы!');
    }

    public function myGroups()
    {
        $user = Auth::user();
        $groups = $user->groups;

        return view('groups.my_group', compact('groups'));
    }

}

