<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FollowUpController extends Controller
{
    public function index()
    {
        $data = FollowUp::all();
        return view('followup.index',compact('data'));
    }

}
