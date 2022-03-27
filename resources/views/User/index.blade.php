@extends('layouts.app')

@section('content')

    <div class="container-fluid mg-t-40">
        <div class="mg-t-20 mg-l-20 d-align-center">
            <img @isset($user->profil_image) src="{{ secure_asset($user->profil_image) }}" @else src="{{ secure_asset('img/default_picture_user.png') }}" @endisset alt="Photo de profil de {{ $user->name }}" style="width:100px;height:100px;border-radius:70px;"/>
            <div>
                <h1 class="mg-l-15 mg-b-0 bolder-text">{{ $user->name }}</h1>
                <span class="mg-l-15 text-11 italic-text">Utilisateur depuis le {{ $user->created_at->format('d/m/Y') }} @if($user->is_admin) - Administrateur @endif</span>
            </div>
        </div>
        <hr>
        <div class="row" style="padding:10px;">
            <!-- début formulaire modification info utilisateur -->
            <x-panel title="Modifier les informations de mon profil" icon="fa-solid fa-id-card fa-2x" class="col-md-6 shadow"> 
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
                        <div class="d-align-center mg-t-30">
                            <button class="btn btn-success btn-sm text-12" style="background-color:#0c2e69 !important;border:1px solid #0c2e69 !important;"><i class="fa-solid fa-square-pen mg-r-5"></i>Modifier mes informations</button>
                            <a href="{{ route('users.destroy',$user->id) }}"  class="btn btn-danger btn-sm text-12 mg-r-5 mg-l-5"><i class="fas fa-user-slash mg-r-5"></i>Supprimer le profil</a>
                            <a href="{{ route('users.deleteVotes',$user->id) }}" class="btn btn-danger btn-sm text-12"><i class="fas fa-folder-minus mg-r-5"></i>Supprimer tous mes votes</a>
                        </div>
                    </form>
                </div>
            </x-panel>

            <!-- début derniers vote de l'utilisateur -->
            <x-panel title="Derniers votes de l'utilisateur" icon="fa-solid fa-check-to-slot fa-2x" class="col-md-5 mg-l-10">
                @if($lastVotes->count() > 0)
                    <div>
                        @foreach($lastVotes as $vote) 
                            <div class="mg-t-20 mg-l-15 d-align-center">
                                <img class="mg-r-5" src="{{ App\LastFMAPIHelper::getCoverAlbum($vote->album->artiste->nom,$vote->album->nom)[1]['#text'] }}" rel="Cover de l'album {{ $vote->album->nom }} de {{ $vote->album->artiste->nom }}" style="border-radius:10px;">
                                <a href="{{ route('album.show',['artist' => $vote->album->artiste->nom, 'album' => $vote->album->nom]) }}" class="flex-column mg-l-10">
                                    <span style="font-size:20px;" class="bolder-text">{{ $vote->note . ' | ' . $vote->album->nom }}</span>
                                    <span class="italic-text" style="font-size:9px;color:grey;">{{ $vote->album->artiste->nom . ' - ' . $vote->updated_at->format('d/m/Y') }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>  
                @else 
                    <div class="container-fluid d-justify-center">
                        <span class="italic-text">Aucune activité récente.</span>
                    </div>
                @endif
            </x-panel>
        </div>
    </div>
@endsection 