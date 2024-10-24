<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    
    public function pages($slug)
    {
        $page = Page::where(['slug' => $slug, 'type' => 'vtfriends'])->first();
        return response()->json($page, 200);
    }
}