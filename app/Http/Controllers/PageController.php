<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Gallery;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $team = TeamMember::all();
        $images = Gallery::all();
        return view('about', compact('team', 'images'));

        // $team = TeamMember::all();
        // return view('about', compact('team'));
        // // return view('about'); // This will return the 'about' view
    }
}
