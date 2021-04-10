<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LastFMAPIHelper;
use App\Models\Vote;
use App\Models\Album;
use App\Models\Artiste;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $albums = Album::withCount(['votes as average_vote' => function($query) {
            $query->select(\DB::raw('coalesce(avg(note),0)'));
        }])->orderByDesc('average_vote')->with('artiste')->get();
        return view('home',compact('albums'));
    }
}
