<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::create([
            'task_id' => $task->id,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Комментарий добавлен!');
    }
}
