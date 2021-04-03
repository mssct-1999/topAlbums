@extends('layouts.app')

@section('content')
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
                <img id="cover" crossorigin="anonymous" src="{{ $album['image'][3]['#text'] }}" alt="Pochette d'album" style="position:relative;top:50px;left:150px;border:1px solid white;"/>
            </div>
        </div>
        <div id="content">
            @if(count($album['tracks']['track']))
                <div id="tracklist-album" class="mg-l-20">
                    <span class="bolder-text main-title">Tracklist</span>
                    @foreach($album['tracks']['track'] as $track)
                        <div class="track-album">
                            <a href="{{ $album['url'] }}" target="_blank" data-toggle="tooltip" data-placement="left" title="Écouter sur LastFM"><img class="disk-image" src="{{ $album['image'][1]['#text'] }}" alt="Pochette album petite"></a>
                            <li class="mg-l-10"><span class="bolder-text">#{{ $track['@attr']['rank'] }}</span> - {{ $track['name'] }}</li>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script>
        $().ready(function() {
            $(window).on('load',function() {
                const colorThief = new ColorThief()
                const img = $("#cover")
                var rgbColors = colorThief.getColor(img[0])
                $("#header-container").css("background-color","rgb(" + rgbColors[0] +"," + rgbColors[1] + "," + rgbColors[2])
            })

            $('a[data-toggle="tooltip"]').tooltip();

        })
    </script>
@endsection