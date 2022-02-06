<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Album;
use App\Models\Artiste;
use Illuminate\Http\Request;
use App\Http\Requests\VoteRequest;

class VoteController extends Controller
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
     * Enregistrement d'un nouveau vote
     */
    public function store(VoteRequest $request) {
        $datas = $request->all();
        // recherche ou création de l'artiste
        $artist = Artiste::createIfNotExist($datas);
        $datas['artiste_id'] = $artist->id;
        // recherche ou création de l'album
        $album = Album::createIfNotExist($datas);
        $datas['album_id'] = $album->id;
        $datas['user_id'] = \Auth::user()->id;

        if (isset($album) && isset($artist)) {
            // 1 vote par utilisateur par album
            $votesExist = Vote::where("user_id","=",$datas['user_id'])->where("album_id","=",$datas['album_id'])->get();
            $checkDatas = $request->validate('create');
            if ($votesExist->count() == 0 && $checkDatas['success']) {
                Vote::create($datas);
            }
        }
        return redirect()->back();
    }

    /**
     * Modification d'un vote
     */
    public function update(VoteRequest $request, Vote $vote) {
        $vote->update(['note' => $request->note]);
        return redirect()->back();
    }
}
