<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        
        $lastVotes = $user->votes()->with('album.artiste')->orderBy('updated_at','desc')->limit(5)->get();
        return view('User.index',compact('lastVotes','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('recentVotes','recentComments.album.artiste');
        return view('User.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $datas = $request->all();
        if(isset($request->profil_picture)) {
            $dataImage = $_FILES['profil_picture']['name'];
            $img = Image::make($_FILES['profil_picture']['tmp_name']);
            // si changement d'image 
            if (isset($user->profil_image)) {
                // suppression de l'ancienne image
                File::delete($user->profil_image);
            }
            // enregistrement de l'image dans public/img/
            $filePath = 'img/' . $request->name . '_' . $dataImage;
            $img->save($filePath);
            // modification de l'url en base de données avec la nouvelle image
            $datas['profil_image'] = $filePath;
        }
        $user->update($datas);
        return redirect()->back()->with('success',"La modification de votre profil s'est correctement effectué.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $hasVotes = $user->votes()->get();
        if ($hasVotes->count() > 0) {
            return back()->with('danger',"Suppression impossible - Cet utilisateur à un ou plusieurs votes d'enregistré.");
        }
        // todo redirection vers login.php -> page d'accueil car plus de compte
        return back()->with('success',"L'utilisateur a correctement été supprimé.");
    }

    /**
     * Supprime tous les votes de l'utilisateur renseigné
     */
    public function deleteVotes(User $user) 
    {
        $user->votes()->delete();
        return back()->with('success',"Tous les votes de {$user->name} ont été supprimé.");
    }
}
