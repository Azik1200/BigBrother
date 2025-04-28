<?php

namespace App\Http\Controllers;

use App\Mail\NewCommentNotification;
use App\Models\Comment;
use App\Models\Nld;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        //TODO MAIL
        //$recipient = 'aziz.salimli@kapitalbank.az';

        //Mail::to($recipient)->send(new NewCommentNotification($request->comment, $nld));

        return redirect()->route('nld.show', $nld->id)
            ->with('success', 'Комментарий добавлен!');
    }
}
