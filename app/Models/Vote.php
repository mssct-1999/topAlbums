<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote
 * 
 * @property int $id
 * @property int $note
 * @property int $user_id
 * @property int $album_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Album $album
 * @property User $user
 *
 * @package App\Models
 */
class Vote extends Model
{
	protected $table = 'votes';

	protected $casts = [
		'user_id' => 'int',
		'album_id' => 'int'
	];

	protected $fillable = [
		'note',
		'user_id',
		'album_id'
	];

	public function album()
	{
		return $this->belongsTo(Album::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
