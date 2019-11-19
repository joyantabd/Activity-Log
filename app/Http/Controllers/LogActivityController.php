<?php

namespace App\Http\Controllers;

use App\LogActivity;

class LogActivityController extends Controller
{
    public function logActivity()
    {
        $logs = LogActivity::all();
        return view('logActivity',compact('logs'));
    }
}
