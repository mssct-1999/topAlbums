<?php

namespace App\Http\Controllers;

use App\LastFMAPIHelper;
use App\Models\Artiste;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ArtisteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Artiste  $artiste
     * @return \Illuminate\Http\Response
     */
    public function show($artiste)
    {
        $artiste = LastFMAPIHelper::getArtiste($artiste);
        $artisteDb = Artiste::whereRaw('UPPER(nom) = UPPER(?)', [$artiste['name']])->with('albums')->first();
        $artisteDb->load('anectodes');
        return view('Artistes.show',compact('artiste','artisteDb'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Artiste  $artiste
     * @return \Illuminate\Http\Response
     */
    public function edit(Artiste $artiste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artiste  $artiste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artiste $artiste)
    {
        $datas = $request->all();
        if ($datas['profil_image']) {
            $file = $request->file('profil_image'); 
            $filename = $artiste->nom . '.' . $file->extension();
            $datas['profil_image'] = asset('storage/artistes/' . $filename);
            Storage::putFileAs('public/artistes',$file,$filename);
            $artiste->update(['profil_image' => 'storage/artistes/' . $filename]);  
            return back()->with('success',"L'artiste a correctement été mis à jour.");           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artiste  $artiste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artiste $artiste)
    {
        //
    }
}
