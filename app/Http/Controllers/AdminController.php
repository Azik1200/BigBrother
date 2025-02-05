<?php

namespace App\Http\Controllers;

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

        return view('admin.users', compact('users'));
    }

    public function showUser($id) {
        $user = User::findOrFail($id);

        $groups = $user->groups;

        return view('admin.user', compact('user', 'groups'));
    }
}
