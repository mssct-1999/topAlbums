<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LastFMAPIHelper;

class LastFMApiController extends Controller
{
    

    /**
     * Recherche d'albums
     */
    public function searchAlbums($name) {
        $datas = LastFMAPIHelper::getAlbumsFromNames($name);
        return response()->json($datas['album']);
    }
}
