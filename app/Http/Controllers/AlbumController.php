<?php

namespace App\Http\Controllers;

use App\LastFMAPIHelper;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    
    /**
     * @param artist : Nom de l'artiste
     * @param album : Nom de l'album
     * Affichage d'un album
     */
    public function show($artist,$album) {
        $album = LastFMAPIHelper::getAlbumInfo($artist,$album)['album'];
        return view('Album.show',compact('album'));
    }
}
