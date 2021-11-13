@extends('layouts.app')

@section('content')
    @isset($user->profil_image)
        <div class="mg-t-20 mg-l-20 d-align-center">
            <img src="{{ asset($user->profil_image) }}" alt="Photo de profile" style="border-radius:100px;width:100px;">
            <h1 class="mg-l-15 bolder-text"><span>@</span>{{ $user->name }}</h1>
        </div>
    @else 
        <div class="mg-l-20 mg-t-20 d-align-center">
           <img src="{{ asset('img/default_picture_user.png') }}" alt="Photo de profile par défaut" style="width:100px;border-radius:100px;">
           <h1 class="mg-l-15 bolder-text"><span>@</span>{{ $user->name }}</h1>
        </div>
    @endisset
    <hr>
    <div class="container-fluid mg-t-40">
        <!-- début formulaire modification info utilisateur -->
        <h4 class="bolder-text">Modifier les informations de mon profil</h4>
        <div class="container-fluid">
            <form action="{{ route('users.update',$user->id) }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label for="pseudoUpdateUser">Pseudonyme :</label>
                    <input id="pseudoUpdateUser" type="text" value="{{ $user->name }}" class="form-control form-control-sm" name="name">
                </div>
                <div class="form-group">
                    <label for="emailUpdateUser">Email :</label>
                    <input id="emailUpdateUser" name="email" type="text" value="{{ $user->email }}" class="form-control form-control-sm" name="name">
                </div>
                <div class="form-group">
                    <span class="mg-r-10">Photo de profil :</span><input name="profil_picture" type="file" id="customFile">
                </div>
                <button class="btn btn-success" style="font-size:10px;">Modifier mes informations</button>
            </form>
        </div>
        <hr>

        <!-- début derniers vote de l'utilisateur -->
        <h4 class="bolder-text">Derniers votes de l'utilisateur</h4>
        <hr>
        <div>
            @foreach($lastVotes as $vote) 
                <div class="mg-t-20 d-align-center">
                    <img class="mg-r-5" src="{{ App\LastFMAPIHelper::getCoverAlbum($vote->album->artiste->nom,$vote->album->nom)[1]['#text'] }}" rel="Cover de l'album {{ $vote->album->nom }} de {{ $vote->album->artiste->nom }}" style="border-radius:10px;">
                    <div class="flex-column mg-l-10">
                        <span style="font-size:20px;" class="bolder-text">{{ $vote->note }}</span>
                        <span class="italic-text" style="font-size:9px;color:grey;">{{ $vote->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection 