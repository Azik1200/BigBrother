<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function userShow(User $user)
    {
        return view('admin.user', [
            'user' => $user,
            'groups' => $user->groups,
            'roles' => $user->roles,
        ]);
    }

    public function usersCreate()
    {
        return view('admin.users.create', [
            'roles' => Role::all(),
            'groups' => Group::all(),
        ]);
    }

    public function usersStore(Request $request)
    {
        $validated = $this->validateUser($request);

        $user = User::create([
            'name' => $validated['name'],
            'surname' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        $this->syncRelations($user, $validated);

        return redirect()->route('admin.users')->with('success', 'Пользователь успешно добавлен!');
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => Role::all(),
            'groups' => Group::all(),
        ]);
    }

    public function usersUpdate(Request $request, User $user)
    {
        $validated = $this->validateUser($request, $user->id);

        $user->update([
            'name' => $validated['name'],
            'surname' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => isset($validated['password'])
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        $this->syncRelations($user, $validated);

        return redirect()->route('admin.users')->with('success', 'Данные пользователя успешно обновлены!');
    }

    /**
     * Validate user data.
     */
    private function validateUser(Request $request, $userId = null)
    {
        $uniqueUsername = 'unique:users,username' . ($userId ? ',' . $userId : '');
        $uniqueEmail = 'unique:users,email' . ($userId ? ',' . $userId : '');

        return $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => "required|string|max:255|$uniqueUsername",
            'email' => "required|email|$uniqueEmail",
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'password' => $userId ? 'nullable|string|min:6|confirmed' : 'required|string|min:6|confirmed',
            'roles' => 'required|array',
            'groups' => 'nullable|array',
        ]);
    }

    /**
     * Sync roles and groups for user.
     */
    private function syncRelations(User $user, array $validated)
    {
        $user->roles()->sync($validated['roles']);

        if (!empty($validated['groups'])) {
            $user->groups()->sync($validated['groups']);
        } else {
            $user->groups()->detach();
        }
    }
}
