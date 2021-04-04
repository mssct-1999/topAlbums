<?php

namespace App\Http\Controllers;

use App\LastFMAPIHelper;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    /**
     * Create a new controller instance
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * @param artist : Nom de l'artiste
     * @param album : Nom de l'album
     * Affichage d'un album
     */
    public function show($artist,$album) {
        $album = LastFMAPIHelper::getAlbumInfo($artist,$album);
        return view('Album.show',compact('album'));
    }
}
