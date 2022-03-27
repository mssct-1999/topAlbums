<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{User};
use App\Models\Commentaire;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Dashboard
     */
    public function index() 
    {
        $inscriptions = (Object)array(
            'today' => User::whereDate('created_at',Carbon::now())->get()->count(),
            'week' => User::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOFWeek())->get()->count(),
            'year' => User::whereYear('created_at',Carbon::now()->year)->get()->count(),
            'diffToday' => User::whereDate('created_at',Carbon::now())->get()->count() - User::whereDate('created_at',Carbon::yesterday())->get()->count(),
            'diffWeek' => User::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOFWeek())->get()->count() - User::whereDate('created_at','>=',Carbon::now()->startOfWeek()->subWeek())->whereDate('created_at','<=',Carbon::now()->endOfWeek()->subWeek())->get()->count(),
            'diffYear' => User::whereYear('created_at',Carbon::now()->year)->get()->count() - User::whereYear('created_at',Carbon::now()->subYear()->year)->get()->count(),
            'total' => User::count() 
        );

        $commentaires = (Object)array(
            'today' => Commentaire::whereDate('created_at',Carbon::now())->get()->count(),
            'week' => Commentaire::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOFWeek())->get()->count(),
            'year' => Commentaire::whereYear('created_at',Carbon::now()->year)->get()->count(),
            'diffToday' => Commentaire::whereDate('created_at',Carbon::now())->get()->count() - Commentaire::whereDate('created_at',Carbon::yesterday())->get()->count(),
            'diffWeek' => Commentaire::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOFWeek())->get()->count() - Commentaire::whereDate('created_at','>=',Carbon::now()->startOfWeek()->subWeek())->whereDate('created_at','<=',Carbon::now()->endOfWeek()->subWeek())->get()->count(),
            'diffYear' => Commentaire::whereYear('created_at',Carbon::now()->year)->get()->count() - Commentaire::whereYear('created_at',Carbon::now()->subYear()->year)->get()->count(),
            'total' => Commentaire::count() 
        );

        $mostActiveUser = \DB::table('votes')
        ->join('users','votes.user_id','users.id')
        ->groupBy('votes.user_id','users.id','users.name','users.profil_image')
        ->select(\DB::raw("users.id,users.name,users.profil_image,COUNT(votes.user_id) as nb_votes"))
        ->orderBy('nb_votes','desc')
        ->first();

        $mostVotedAlbum = \DB::table('votes')
            ->join('albums','votes.album_id','albums.id')
            ->join('artistes','albums.artiste_id','artistes.id')
            ->groupBy('votes.album_id','albums.id','albums.nom','artistes.nom')
            ->select(\DB::raw('albums.id,albums.nom,artistes.nom as artiste,COUNT(votes.album_id) as nb_votes'))
            ->orderBy('nb_votes','desc')
            ->first();

        $votes = (Object)array(
            'today' => Vote::whereDate('created_at',Carbon::now())->get()->count(),
            'week' => Vote::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOfWeek())->get()->count(),
            'year' => Vote::whereYear('created_at',Carbon::now()->year)->get()->count(),
            'diffToday' => Vote::whereDate('created_at',Carbon::now())->get()->count() - Vote::whereDate('created_at',Carbon::yesterday())->get()->count(),
            'diffWeek' => Vote::whereDate('created_at','>=',Carbon::now()->startOfWeek())->whereDate('created_at','<=',Carbon::now()->endOFWeek())->get()->count() - Vote::whereDate('created_at','>=',Carbon::now()->startOfWeek()->subWeek())->whereDate('created_at','<=',Carbon::now()->endOfWeek()->subWeek())->get()->count(),
            'diffYear' => Vote::whereYear('created_at',Carbon::now()->year)->get()->count() - Vote::whereYear('created_at',Carbon::now()->subYear()->year)->get()->count(),
            'total' => Vote::count(),
            'mostActiveUser' => $mostActiveUser,
            'mostVotedAlbum' => $mostVotedAlbum
        ); 

        return view('Admin.index',compact('inscriptions','votes','commentaires'));
    }

    /**
     * @param Request
     * Remote connexion  
     */ 
    public function launchRemoteConnection(User $user) 
    {
        $credentials = array(
            'email' => $user->email, 
            'password' => $user->password
        );
        if ($user->exists) {
            \Auth::login($user);
            return redirect()->route('home');
        }
    }   

    ////////////////////////
    /// API 
    ///////////////////////

    public function searchUser($libelle, User $user)
    {
        if (!empty($libelle)) {
            $users = User::whereRaw("UPPER(name) LIKE UPPER(?)",['%' . $libelle . '%'])->get();
            return response()->json($users);
        }
        if ($user->exists) {
            return response()->json($user);
        }
    }
}
