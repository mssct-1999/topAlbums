<?php

namespace App\Http\Controllers;

use App\LastFMAPIHelper;
use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Artiste;
use App\Models\Commentaire;
use App\Models\Vote;
use Egulias\EmailValidator\Warning\Comment;

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
        $artisteDb = Artiste::whereRaw("UPPER(nom) = ?", [strtoupper($artist)])->first();
        $votes = null;
        $userVote = null;
        $lastVotes = null;
        $albumDb = null;
        $comments = [];
        // si il y a eu des votes pour cet album
        if (isset($artisteDb)) {
            $albumDb = Album::whereRaw("UPPER(nom) = ?", [strtoupper($album['name'])])->where("artiste_id","=",$artisteDb->id)->first();
            if ($albumDb) {
                $votes = $albumDb->votes()->get();
                $userVote = Vote::where("user_id","=",\Auth::user()->id)->where("album_id","=",$albumDb->id)->first();
                $lastVotes = Vote::where("album_id","=",$albumDb->id)->with('user')->limit(5)->orderBy('updated_at')->get();
                $comments = Commentaire::where('id_album',"=",$albumDb->id)->with('user')->get();
            }
        } 
        return view('Album.show',compact('album','votes','userVote','lastVotes','comments','albumDb'));
    }
}
