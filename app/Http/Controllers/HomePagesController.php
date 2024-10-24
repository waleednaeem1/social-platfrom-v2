<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePagesController extends Controller
{
    public function newsfeed(Request $request)
    {
        return view('dashboards.newsfeed');
    }
}
