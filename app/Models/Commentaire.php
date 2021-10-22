<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commentaire
 */
class Commentaire extends Model
{
	protected $table = 'comments';

	protected $casts = [
		'id_user' => 'int',
		'id_album' => 'int'
	];

	protected $fillable = [
		'comments',
        'title',
		'id_user',
		'id_album',
        'created_at',
		'updated_at'
	];

	public function album()
	{
		return $this->belongsTo(Album::class,'id_album');
	}

	public function user()
	{
		return $this->belongsTo(User::class,'id_user');
	}
}
