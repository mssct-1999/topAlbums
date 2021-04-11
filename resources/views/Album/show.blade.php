@extends('layouts.app')

@section('content')
    @if(isset($album))
        <div id="header-container" style="height:200px;width:100%;margin-top:0px !important;" data-img-url="{{ $album['image'][2]['#text'] }}">
            <div id="album-text-info" class="container" style="display:flex;justify-content:space-between;">
                <div class="mg-t-20" style="display:flex;flex-direction:column;">
                    <span class="barlow-font" style="color:white;font-size:18px;">{{ $album['artist'] }}</span>
                    <span class="barlow-font bolder-text" style="color:white;font-size:48px;">{{ $album['name'] }}</span>
                    @if(isset($album['wiki']['published']))
                        <span class="barlow-font" style="color:white;">Sortie le {{ $album['wiki']['published'] }}</span>
                    @endif
                </div>
                <div id="container-cover" style="display:flex; justify-content:flex-end;">
                    <img id="cover" crossorigin="anonymous" src="{{ $album['image'][3]['#text'] }}" alt="Pochette d'album" style="position:relative;top:20%;left:50%;border:1px solid lightgrey;"/>
                </div>
            </div>
            <div id="content">
                @if(count($album['tracks']['track']))
                    <div style="display:flex;justify-content:flex-start;"> 
                        <div id="tracklist-album" class="mg-l-20 shadow">
                            <span class="bolder-text main-title">Tracklist</span>
                            @foreach($album['tracks']['track'] as $track)
                                <div class="track-album">
                                    <a href="{{ $album['url'] }}" target="_blank" data-toggle="tooltip" data-placement="left" title="Écouter sur LastFM"><img class="disk-image" src="{{ $album['image'][1]['#text'] }}" alt="Pochette album petite"></a>
                                    <li class="mg-l-10"><span class="bolder-text">#{{ $track['@attr']['rank'] }}</span> - {{ $track['name'] }}</li>
                                </div>
                            @endforeach
                        </div>
                @endif
                <div id="container-right" class="mg-l-20" style="width:40%;">   
                    <div id="notation-album" class="mg-l-10 shadow">
                        <span class="bolder-text main-title">Notation</span>
                        <div class="d-align-center d-space-between box">
                            @if(isset($votes))
                                <div>
                                    <svg class="radial-progress" data-percentage="{{ $votes->avg('note') }}" viewBox="0 0 100 100">
                                        <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                        <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                        <text class="percentage bolder-text" x="50%" y="50%" transform="matrix(0, 1, -1, 0, 85, -10)">{{ round($votes->avg('note'),2) }} /10</text>
                                    </svg>
                                </div>
                            @else
                                <div>
                                    <span class="italic-text">Cet album n'a pas encore été noté pour l'instant</span>
                                </div>
                            @endif
                            @if(!isset($userVote))
                                <form action="{{ route('votes.store') }}" method="POST">
                            @else 
                                <form action="{{ route('votes.update',['vote' => $userVote->id]) }}" method="POST">
                            @endif
                                @csrf
                                <div class="d-align-center mg-t-10 mg-b-10">
                                    <input value="{{ isset($userVote) ? $userVote->note : null }}" type="text" name="note" class="form-control form-control-sm" style="width:50px;" required>
                                    <input type="hidden" name="artist" value="{{ $album['artist']  }}">
                                    <input type="hidden" name="album" value="{{ $album['name'] }}">
                                    <span class="mg-l-10 bolder-text">/ 10</span>
                                    @if(!isset($userVote))
                                        <button id="voteButton" class="btn mg-l-10" style="color:white;font-size:11px;padding:5px;">Voter</button>
                                    @else
                                        <button id="voteButton" class="btn mg-l-10" style="color:white;font-size:11px;padding:5px;">Modifier</button>
                                    @endif
                                </div>
                                <span class="italic-text" style="color:grey;font-size:10px;">Un vote seulement / Nombre à virgule autorisé. (Remplacer la virgule par un point)</span>
                            </form>
                        </div>
                    </div>
                    @if(isset($lastVotes))
                        <div class="mg-l-10 shadow">
                            <span class="bolder-text main-title">Derniers votes</span>
                            @foreach($lastVotes as $vote)
                                <li class="mg-t-10">{{ $vote->updated_at->format('d/m/Y')}} - {{ $vote->user->name  }} - 
                                    @if ($vote->note >= 7)
                                        <span style="color:#4DC274;" class="italic-text bolder-text">{{ $vote->note }}</span>
                                    @elseif($vote->note < 7 && $vote->note >= 5)
                                        <span style="color:#F56702;" class="italic-text bolder-text">{{ $vote->note }}</span>
                                    @else
                                        <span style="color:#E62737;" class="italic-text bolder-text">{{ $vote->note }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <!-- TODO posts/commentaires -->
                </div>
            </div>
        </div>
    @else
        <div style="height:50vh;" class="container d-justify-center d-align-center">
            <div>
                <span class="main-title">Whoops ! L'album que vous cherchez n'est pas disponible ou n'existe pas...</span>
            </div>
        </div>
    @endif
@endsection