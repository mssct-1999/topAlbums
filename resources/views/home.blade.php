@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="main-title mg-t-30">Bienvenue {{ Auth::user()->name }} !</h1>
    <div class="mg-t-50">
        <h1 class="main-title mg-b-20">Classement</h1>
        @if(isset($albums))
            @foreach($albums as $index => $album)
                <div class="d-align-center">
                    <span class="bolder-text mg-r-10">#{{ $index+1 }}</span>
                    <div class="mg-b-10 d-align-center shadow" style="padding:10px;border-radius:50px;width:100%;justify-content:space-between">
                        <a href="{{ route('album.show',['artist' => $album->artiste->nom, 'album' => $album->nom]) }}">   
                            <li> 
                                <img class="disk-image-50" src="{{ $album->cover[1]['#text'] }}" alt="Cover de l'album {{ $album->nom }} de {{ $album->artiste->nom }}"/> {{ $album->nom }} / {{ $album->artiste->nom }}
                            </li>
                        </a>
                        @if($album->average_vote >= 7)
                            <span class="bolder-text" style="color:#4DC274;">{{ $album->average_vote }}</span>
                        @elseif($album->average_vote < 7 && $album->average_vote >= 5)
                            <span style="color:#F56702;" class="bolder-text">{{ $album->average_vote }}</span>                        
                        @else
                            <span style="color:#E62737;" class="bolder-text">{{ $album->average_vote }}</span>                        
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
