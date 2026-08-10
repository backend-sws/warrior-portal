<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tuitions = \App\Models\HomeTuitionLead::where('user_id', auth()->id())->latest()->get();
        return view('parent.dashboard', compact('tuitions'));
    }
}
