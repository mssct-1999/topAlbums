<?php

namespace App;

use Illuminate\Support\Facades\Http;

class LastFMAPIHelper {

    private static $ACCESS_TOKEN = "a62ac89f85a8c8d78a6e7fe4849aa66c";
    private static $SECRET = "4dccf1d5a95ea8d5a986a9ba0a3b5f69";
    private static $API_URL = "http://ws.audioscrobbler.com/2.0/";

    /**
     * @param limit : Nombre de données max
     * @param name : Nom de l'album
     * Fonction: getAlbumsFromNames
     * Description: Retourne la liste des albums correspondant au nom passé en paramètre
     */
    public static function getAlbumsFromNames($name,$limit = 10) {
        $url = self::$API_URL . "?method=album.search&api_key=". self::$ACCESS_TOKEN ."&album=". urlencode($name) ."&limit=" . $limit . "&format=json";
        $response = Http::get($url);
        return $response->json()["results"]['albummatches'];
    }

    /**
     * @param artist : Nom de l'artiste
     * @param album : Nom de l'album
     * Fonction: getAlbumInfo
     * Description: Retourne les informations d'un album
     */
    public static function getAlbumInfo($artist,$album) {
        $url = self::$API_URL . "?method=album.getinfo&api_key=" . self::$ACCESS_TOKEN . "&artist=" . urlencode($artist) . "&album=" . urlencode($album) . "&format=json";
        $response = Http::get($url);
        $datas = $response->json();
        if (!isset($datas['album'])) {
            return null;
        }
        return $response->json()['album'];
    }

    /**
     * @param artist: Nom de l'artiste
     * @param album: Nom de l'album
     * Fonction: getCoverAlbum
     * Description: Retourne la cover d'un album de l'artiste passé en paramètre
     */
    public static function getCoverAlbum($artist,$album) {
        $url = self::$API_URL . "?method=album.getinfo&api_key=" . self::$ACCESS_TOKEN . "&artist=" . urlencode($artist) . "&album=" . urlencode($album) . "&format=json";
        $response = Http::get($url);
        $datas = $response->json();
        if (!isset($datas['album'])) {
            return null;
        }
        return $response->json()['album']['image'];
    }

    /**
     * @param artist : Nom de l'artiste
     */
    public static function getArtiste($artist) 
    {
        $url = self::$API_URL . "?method=artist.getinfo&api_key=" . self::$ACCESS_TOKEN . "&artist=" . urlencode($artist) . "&format=json"; 
        $response = Http::get($url);
        $datas = $response->json();
        if (!isset($datas['artist'])) {
            return null;
        }
        return $datas['artist'];
    }

    /**
     * 
     */
    public static function getArtistesFromNom($name,$limit = 10)
    {
        $url = self::$API_URL . "?method=artist.search&api_key=" . self::$ACCESS_TOKEN . "&artist=" . urlencode($name)  ."&limit=" . $limit . "&format=json";
        $response = Http::get($url);
        return $response->json()['results']['artistmatches'];
    }
}

?>