<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Anectode
 *
 *
 * @package App\Models
 */
class Anectode extends Model
{
	protected $table = 'anectodes';

	protected $fillable = [
		'contenu',
        'id_user',
        'id_artiste',
        'certified'
	];

	public function user() 
    {
        return $this->belongsTo(User::class,'id_user');
    }

    public function artiste()
    {
        return $this->belongsTo(Artiste::class,'id_artiste');
    }
}
