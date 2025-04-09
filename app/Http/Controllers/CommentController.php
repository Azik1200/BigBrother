<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Nld;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Nld $nld)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::create([
            'nld_id' => $nld->id,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('nld.show', $nld->id)
            ->with('success', 'Комментарий добавлен!');
    }
}
