<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccActivity;

class ActivitiesController extends Controller
{
    public function index() {
        $activities = AccActivity::orderBy('created_at', 'desc')->take(1000)->get();
        return view('access.activities.index', compact('activities'));
    }
}
