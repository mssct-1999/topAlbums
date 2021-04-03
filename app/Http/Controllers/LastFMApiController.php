<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LastFMAPIHelper;

class LastFMApiController extends Controller
{
    

    /**
     * @param name : Nom de l'album 
     * Recherche d'albums
     */
    public function searchAlbums($name) {
        $datas = LastFMAPIHelper::getAlbumsFromNames($name);
        return response()->json($datas['album']);
    }

    /**
     * @param album : Nom de l'album
     * @param artist : Nom de l'artiste
     * Affichage d'un album
     */
    public function showAlbum($album,$artist) {
        $datas = LastFMAPIHelper::getAlbumInfo($artist,$album);
        return response()->json($datas);
    }
}
