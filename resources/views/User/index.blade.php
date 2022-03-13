@extends('layouts.app')

@section('content')

    <div class="container-fluid mg-t-40">
        @isset($user->profil_image)
            <div class="mg-t-20 mg-l-20 d-align-center">
                <img src="{{ secure_asset($user->profil_image) }}" alt="Photo de profile" style="border-radius:100px;width:100px;">
                <h1 class="mg-l-15 bolder-text">{{ $user->name }}</h1>
            </div>
        @else 
            <div class="mg-l-20 mg-t-20 d-align-center">
            <img src="{{ secure_asset('img/default_picture_user.png') }}" alt="Photo de profile par défaut" style="width:100px;border-radius:100px;">
            <h1 class="mg-l-15 bolder-text"><span>@</span>{{ $user->name }}</h1>
            </div>
        @endisset
        <hr>
        <div class="row" style="padding:10px;">
            <!-- début formulaire modification info utilisateur -->
            <div class="col-md-6 shadow"> 
                <h4 class="bolder-text">Modifier les informations de mon profil</h4>
                <hr>
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
                        <button class="btn btn-success mg-b-30" style="font-size:10px;">Modifier mes informations</button>
                    </form>
                    <div>
                        <h5 class="bolder-text mg-b-10" style="color:#e3342f;"><i class="fas fa-exclamation-triangle mg-r-5"></i>Zone rouge</h5>
                        <a href="{{ route('users.destroy',$user->id) }}"  class="badge badge-danger text-12"><i class="fas fa-user-slash mg-r-5"></i>Supprimer le profil</a>
                        <a href="{{ route('users.destroy',$user->id) }}" class="badge badge-danger text-12">Supprimer tous mes votes</a>
                    </div>
                </div>
            </div>

            <!-- début derniers vote de l'utilisateur -->
            <div class="col-md-6">
                <h4 class="bolder-text">Derniers votes de l'utilisateur</h4>
                <hr>
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
            </div>
        </div>
    </div>
@endsection 