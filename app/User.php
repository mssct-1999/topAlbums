<?php

namespace App;


use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use App\Models\Vote;
use App\Models\Commentaire;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','profil_image','is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'int'
    ];

    /**
     * @param user 
     * Détermine si l'utilistaeur pasé en paramètre est un administrateur
     */
    public static function isAdmin($user)
    {
        if (isset($user)) {
            if ($user->is_admin) {
                return true;
            }
            else {
                return false;
            }
        } 
        else {
            return false;
        }
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function recentVotes() 
    {
        return $this->hasMany(Vote::class)->orderBy('created_at','desc')->limit(5);
    }

    public function recentComments() 
    {
        return $this->hasMany(Commentaire::class,'id_user')->orderBy('created_at','desc')->limit(5);
    }

    public function comments_liked() 
    {
        return $this->belongsToMany('App\Models\Commentaire','comment_like','id_user','id_comment');
    }
}
