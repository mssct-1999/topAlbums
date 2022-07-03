<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\LastFMAPIHelper;

/**
 * Class Album
 * 
 * @property int $id
 * @property string $nom
 * @property int $artiste_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Artiste $artiste
 * @property Collection|Vote[] $votes
 *
 * @package App\Models
 */
class Album extends Model
{
	protected $table = 'albums';

	protected $casts = [
		'artiste_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'artiste_id'
	];

	protected $appends = [
		'average_notation'
	];

	public function artiste()
	{
		return $this->belongsTo(Artiste::class);
	}

	public function votes()
	{
		return $this->hasMany(Vote::class);
	}

	/**
	 * @param album : Nom de l'album
	 * Fonction: exist
	 * Description: Retourne vrai si l'album recherché est déjà présent dans la table Albums.
	 */
	public static function exist($album) {
		$results = Album::whereRaw('UPPER(nom) = ?',[strtoupper($album)])->get();
		if ($results->count() > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @param datas : Données nécesssaire pour la création d'un album => données requises : album (nom de l'album) / artiste_id (identifiant de l'artiste)
	 * Fonction: createIfNotExist
	 * Description: Cherche en base si un album existe, si oui retourne cet album, si non créer et retourne cet album.
	 */
	public static function createIfNotExist($datas) {
		if (self::exist($datas['album'])) {
			return self::where("artiste_id","=",$datas['artiste_id'])->whereRaw('UPPER(nom) = ?',[strtoupper($datas['album'])])->first();
		}
		else {
			return self::create(['nom' => $datas['album'], "artiste_id" => $datas["artiste_id"]]);
		}
	}

	/**
	 * Fonction: getCoverImageAttribute
	 * Description: Fonction d'attribut dynamique
	 */
	public function getCoverAttribute() {
		$artist = $this->artiste()->first();
		return LastFMAPIHelper::getCoverAlbum($artist->nom,$this->nom);
	}

	/**
	 * Propriété dynamique -> retourne la note moyenne des votes pour l'album courant.
	 */
	public function getAverageNotationAttribute()
	{
		return $this->votes()->avg('note');
	}
}
