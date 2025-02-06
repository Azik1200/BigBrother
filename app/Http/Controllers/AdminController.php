<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    public function userShow(User $user) {
        $groups = $user->groups;
        $roles = $user->roles;

        return view('admin.user', compact('user', 'groups', 'roles'));
    }

    public function usersCreate() {
        $roles = Role::all();
        $groups = Group::all();

        return view('admin.users.create', compact('roles', 'groups'));
    }

    public function usersStore(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'password' => 'required|string|min:6|confirmed',
            'roles' => 'required|array',
            'groups' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'surname' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->roles()->attach($validated['roles']);

        if (!empty($validated['groups'])) {
            $user->groups()->attach($validated['groups']);
        }

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно добавлен!');
    }

    public function usersEdit(User $user)
    {
        $roles = Role::all();
        $groups = Group::all();

        return view('admin.users.edit', compact('user', 'roles', 'groups'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'password' => 'nullable|string|min:6|confirmed',
            'roles' => 'required|array',
            'groups' => 'nullable|array',
        ]);

        $user->update([
            'name' => $validated['name'],
            'surname' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);


        $user->roles()->sync($validated['roles']);

        if (!empty($validated['groups'])) {
            $user->groups()->sync($validated['groups']);
        } else {
            $user->groups()->detach();
        }

        return redirect()->route('admin.users')->with('success', 'Данные пользователя успешно обновлены!');
    }
}
