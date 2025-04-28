<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    public function index()
    {
        $followUps = FollowUp::all();

        return view('followup.index', [
            'data' => $followUps,
        ]);
    }
}
