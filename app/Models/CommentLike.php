<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CommentLike
 *
 * @package App\Models
 */
class CommentLike extends Model
{
	protected $table = 'comment_like';

	protected $casts = [
		'id_user' => 'int',
		'id_comment' => 'int'
	];

	protected $fillable = [
		'id_user',
		'id_comment',
	];

    public function comment() 
    {
        return $this->belongsTo(Commentaire::class,'id_comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
}
