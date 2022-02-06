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
        //
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
        // dd($_FILES);
        if(isset($request->profil_picture)) {
            $dataImage = $_FILES['profil_picture']['name'];
            $img = Image::make($_FILES['profil_picture']['tmp_name']);
            // si changement d'image 
            if (isset($user->profil_image)) {
                // suppression de l'ancienne image
                File::delete($user->profil_image);
            }
            $filePath = 'img/' . $request->name . '_' . $dataImage;
            $img->save($filePath);
            $datas['profil_image'] = $filePath;
        }
        $user->update($datas);
        return redirect()->back();
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
            $_GET['confirmDelete'] = true;
            return back();
        }
        // todo redirection vers login.php -> page d'accueil car plus de compte
        return back()->with('success',"L'utilisateur a correctement été supprimé.");
    }
}
