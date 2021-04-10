<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Artiste
 * 
 * @property int $id
 * @property string $nom
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Album[] $albums
 *
 * @package App\Models
 */
class Artiste extends Model
{
	protected $table = 'artistes';

	protected $fillable = [
		'nom'
	];

	public function albums()
	{
		return $this->hasMany(Album::class);
	}

	/**
	 * @param artist: Nom de l'artiste
	 * Fonction: exist
	 * Description: Retourne vrai si l'album recherché est déjà présent dans la table Artiste
	 */
	public static function exist($artist) {
		$results =  Artiste::whereRaw('UPPER(nom) = ?',[strtoupper($artist)])->get();
		if ($results->count() > 0) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * @param datas : Données nécesssaire pour la création d'un artiste
	 * Fonction: createIfNotExist
	 * Description: Cherche en base si un artiste existe, si oui retourne cet artiste, si non créer et retourne cet artiste.
	 */
	public static function createIfNotExist($datas) {
		if (self::exist($datas['artist'])) {
			return Artiste::whereRaw('UPPER(nom) = ?',[strtoupper($datas['artist'])])->first();
		}
		else {
			return Artiste::create(['nom' => $datas['artist']]);
		}
	}
}
