<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Top Albums</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link rel="shortcut icon" href="{{ secure_asset('img/logo.png') }}" type="image/x-icon">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    𝙏𝙊𝙋 𝘼𝙇𝘽𝙐𝙈𝙎
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Se connecter</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                                </li>
                            @endif
                        @else
                            <div class="searchbar mg-r-20 mg-t-5">
                                <form id="searchbarForm" style="display:flex;align-items:center;">
                                    <input id="searchAlbums" class="form-control form-control-sm" type="text" name="" placeholder="Search..." style="width:300px;">
                                </form>
                            </div>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('users.index') }}" class="dropdown-item">Profil</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Déconnexion
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="py-4">
            <input type="hidden" value="{{ url('/') }}" id="baseUrl">
            @yield('content')
        </main>
    </div>
</body>
<script>
    var baseUrl = $("#baseUrl").val()

    $("#searchAlbums").autocomplete({
        source: function(request,response) {
            appendTo:this,
            $.getJSON(baseUrl + "/lastfmapi/getAlbumByName/" + request.term, function(data) {
                response($.map(data,function(value,key) {
                    return {
                        label: value.name + " -  " + value.artist,
                        value: value.name,
                        album: value.name,
                        artist: value.artist,
                        image: value.image[0]["#text"]
                    }
                }))
            });
        },
        select: function(event,ui) {
            $("#searchbarForm").attr('action',baseUrl + "/albums/show/" + ui.item.artist + "/" + ui.item.album)
            $("#searchbarForm").submit()
        }
    });

    $("#searchAlbums").data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    var $li = $('<li>'),
        $img = $('<img>');

        $img.attr({
            src: item.image,
            alt: item.label,
            style: 'margin-right:5px;background-color:transparent;border:none;'
        });


    $li.attr('data-value', item.label);
    $li.append($img).append(item.label);    

    return $li.appendTo(ul);
  };
</script>
</html>
