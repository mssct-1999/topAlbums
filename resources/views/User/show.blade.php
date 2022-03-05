@extends('layouts.app')

@section('content')
    
    <div class="container-fluid mg-t-40">
        <div class="mg-t-20 mg-l-20 d-align-center">
            <img @isset($user->profil_image) src="{{ secure_asset($user->profil_image) }}" @else src="{{ secure_asset('img/default_picture_user.png') }}" @endisset alt="Photo du profil de {{ $user->name }}" style="width:100px;border-radius:100px;"/>
            <h1 class="mg-l-15 bolder-text"><span>@</span>{{ $user->name }}</h1>
        </div>
        <hr>

        <!-- Derniers votes -->
        <div class="row" style="padding:10px;">
            <div class="col-md-12 shadow">
                <h4 class="bolder-text">Derniers votes</h4>
                <hr>
                @if($user->recentVotes->count() > 0)
                    <div>
                        @foreach($user->recentVotes as $vote)
                            @if ($vote->note >= 7)
                                <div class="mg-t-20 mg-l-15 d-align-center alert alert-success">
                            @elseif($vote->note < 7 && $vote->note >= 5)
                                <div class="mg-t-20 mg-l-15 d-align-center alert alert-warning">
                            @else 
                                <div class="mg-t-20 mg-l-15 d-align-center alert alert-danger">
                            @endif
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
                        <span class="italic-text">Aucun vote récent.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Derniers commentaires -->
        <div class="row mg-t-10" style="padding:10px;">
            <div class="col-md-12 shadow">
                <h4 class="bolder-text">Derniers commentaires</h4>
                <hr>
                @if($user->recentComments->count() > 0)
                    <div>
                        @foreach($user->recentComments as $comment)
                            <div class="mg-t-20 mg-l-15 d-align-center">
                                <img class="mg-r-5" src="{{ App\LastFMAPIHelper::getCoverAlbum($comment->album->artiste->nom,$comment->album->nom)[1]['#text'] }}" rel="Cover de l'album {{ $comment->album->nom }} de {{ $comment->album->artiste->nom }}" style="border-radius:10px;">
                                <a href="{{ route('album.show',['artist' => $comment->album->artiste->nom, 'album' => $comment->album->nom]) }}" class="flex-column mg-l-10">
                                    <span style="font-size:20px;" class="bolder-text">{{ $comment->title }}</span>
                                    <span class="italic-text" style="font-size:11px;color:grey;">{{ $comment->comments }}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else 
                    <div class="container-fluid d-justify-center">
                        <span class="italic-text">Aucun commentaire récent.</span>
                    </div>
                @endif
            </div>
        </div>  
    </div>
@endsection