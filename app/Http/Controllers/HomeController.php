<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LastFMAPIHelper;
use App\Models\Vote;
use App\Models\Album;
use App\User;
use App\Models\Artiste;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

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

    /////////////////////////
    /// API
    /////////////////////////

    /**
     * @param String query
     * 
     * Recherche parmis les utilisateurs de l'application ou les albums
     */
    public function searchArtisteOrUsers(String $query) 
    {
        $reponse = collect(LastFMAPIHelper::getAlbumsFromNames($query)['album']);
        $users = User::whereRaw('UPPER(name) LIKE UPPER(?)',['%'. $query .'%'])->get();
        $reponse = $reponse->merge($users)->sortBy('name');
        return response()->json($reponse);
    }

    /**
     * Retourne le classement des albums selon leur note moyenne.
     */
    public function getClassement() 
    {
        $albums = Cache::remember('albums',Carbon::now()->addHour(),function()  {
            $albums = Album::withCount(['votes as average_vote' => function($query) {
                $query->select(\DB::raw('coalesce(avg(note),0)'));
            }])
            ->orderByDesc('average_vote')
            ->with('artiste')->get();
            $albums->map(function($album,$key) {
                return $album->small_cover = $album->cover[1]['#text'];
            }); 
            return $albums; 
        });
        return response()->json($albums);
    }
}
