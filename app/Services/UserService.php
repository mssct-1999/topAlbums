<?php 


namespace App\Services;

use App\Models\Artiste;
use App\User;

class UserService 
{


    /**
     * Retourne l'artiste préféré selon les votes de l'utilisateur passé en paramètre.
     * @param \App\User user
     */
    public function getFavoriteArtiste(User $user)
    {
        $user->load('votes.album.artiste');
        $votesByArtistes = collect();
        $user->votes->map(function($value,$key) use($votesByArtistes) {
            $artiste_id = $value->album->artiste->id;
            if($votesByArtistes->has($artiste_id)) {
                $new_avg_artiste = ($votesByArtistes->get($artiste_id) + $value->note) / 2;
                $votesByArtistes->put($artiste_id,$new_avg_artiste); 
            }
            else {
                $votesByArtistes->put($artiste_id,$value->note);
            }
        });
        $favorite_artiste = $votesByArtistes->sortDesc()->take(1)->keys()->first();
        return ['artist' => Artiste::find($favorite_artiste),"note" => $votesByArtistes->sortDesc()->take(1)->first()];
    }

    /**
     * Retourne les 5 artistes favoris selon les votes de l'utilisateur passé en paramètre.
     */
    public function getFavoriteArtistes(User $user)
    {
        $user->load('votes.album.artiste');
        $votesByArtistes = collect();
        $user->votes->map(function($value,$key) use($votesByArtistes) {
            $artiste_id = $value->album->artiste->id;
            if($votesByArtistes->has($artiste_id)) {
                $new_avg_artiste = ($votesByArtistes->get($artiste_id) + $value->note) / 2;
                $votesByArtistes->put($artiste_id,$new_avg_artiste); 
            }
            else {
                $votesByArtistes->put($artiste_id,$value->note);
            }
        });

        $favorite_artistes = $votesByArtistes->sortDesc()->take(5)->keys();
        $result = collect();
        $favorite_artistes->map(function($artiste_id,$vote) use($result) {
            $artiste = Artiste::find($artiste_id);
            $artiste->vote_avg = $vote;
            $result->push($artiste);
        });
        return $result;
    }
}