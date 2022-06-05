<?php 

namespace App; 

use Illuminate\Support\Facades\Http;

class MusicBrainzApiHelper 
{
    private const API_URL = "https://musicbrainz.org/ws/2/";


    /**
     * 
     */
    public static function getArtiste($mbid) {
        $url = self::API_URL . "artist/" . $mbid . '/?inc=url-rels';
        $response = Http::accept('application/json')->get($url); 
        dd($response->json());
        return $response->json();
    } 
    
}