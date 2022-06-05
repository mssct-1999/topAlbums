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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dark-app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('img/icon.png') }}" type="image/x-icon">
</head>
<body @if($theme == 'dark') class="dark-theme" @endif>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm {{ $theme == 'dark' ? 'dark-theme' : null }}">
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
                                    @isset(Auth::user()->profil_image) 
                                        <img src="{{ asset(Auth::user()->profil_image) }}" style="width:30px;height:30px;border-radius:20px;"/> 
                                    @else
                                        <img src="{{ asset('img/default_picture_user.png') }}" style="width:30px;height:30px;border-radius:20px;"/> 
                                    @endisset

                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('users.index') }}" class="dropdown-item"><i class="fas fa-user-circle mg-r-10"></i>Profil</a>
                                    @admin
                                        <a href="{{ route('admin.index') }}" class="dropdown-item"><i class="fas fa-crown mg-r-10"></i>Administration</a>
                                    @endadmin
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       <i class="fa-solid fa-arrow-right-from-bracket mg-r-10"></i>Déconnexion
                                    </a>
                                    

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                    @endguest
                    <div id="themeStyle" class="d-align-center">
                        <i id="toggleThemeIcon" data-theme="light" data-toggle="tooltip" title="Changer le thème" @if ($theme == 'light') class="fa-solid fa-moon"  @elseif($theme == 'dark')  class="fa-solid fa-sun" @endif></i>
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <input type="hidden" value="{{ url('/') }}" id="baseUrl">
            @yield('content')
        </main>
    </div>
</body>
@stack('js')
<script>
    
    $("#searchAlbums").autocomplete({
        source: function(request,response) {
            appendTo:this,
            $.getJSON(baseUrl + "/search/" + request.term, function(data) {
                response($.map(data,function(value,key) {
                    // si il y a un id + name -> c'est un utilisateur
                    if (value.id && value.name) {
                        return {
                            label: value.name + " (Utilisateur)",
                            value: value.name, 
                            image: value.profil_image,
                            user_id:value.id
                        }
                    }
                    // si pas de nom d'artiste renseigné et nom -> c'est un artiste
                    else if (value.name && !value.artist) {
                        return {
                            label: value.name + " (Artiste)",
                            value: value.name, 
                            artist: value.name,
                            image: value.image[0]["#text"],
                        }  
                    }
                    // sinon c'est un album
                    else {
                        return {
                            label: value.name + " -  " + value.artist,
                            value: value.name,
                            album: value.name,
                            artist: value.artist,
                            image: value.image[0]["#text"]
                        }
                    }

                }))
            });
        },
        select: function(event,ui) {
            if (!ui.item.user_id && ui.item.album) {
                $("#searchbarForm").attr('action',baseUrl + "/albums/show/" + ui.item.artist + "/" + ui.item.album)
                $("#searchbarForm").submit()
            }
            else if (ui.item.user_id) {
                $("#searchbarForm").attr('action',baseUrl + "/users/show/" + ui.item.user_id)
                $("#searchbarForm").submit() 
            }
            else if (ui.item.artist && !ui.item.album) {
                $("#searchbarForm").attr('action',baseUrl + "/artistes/show/" + ui.item.value)
                $("#searchbarForm").submit() 
            }
        }
    });

    $("#searchAlbums").data( "ui-autocomplete" )._renderItem = function( ul, item ) {
    var $li = $('<li>'),
        $img = $('<img>');

        if (item.user_id) {
            $img.attr({
                src: baseUrl + "/" + item.image,
                alt: item.label,
                style: 'margin-right:5px;background-color:transparent;border:none;width:50px;'
            }); 
        }
        else {
            $img.attr({
                src: item.image,
                alt: item.label,
                style: 'margin-right:5px;background-color:transparent;border:none;width:50px;'
            });
        }

    $li.attr('data-value', item.label);
    $li.append($img).append(item.label);    

    return $li.appendTo(ul);
  };
</script>
<script>
/**
    tarteaucitron.init({
        "privacyUrl": "", /* Privacy policy url */

        //"hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
        //"cookieName": "tarteaucitron", /* Cookie name */

        //"orientation": "middle", /* Banner position (top - bottom - middle - popup) */

        //"groupServices": false, /* Group services by category */

        //"showAlertSmall": false, /* Show the small banner on bottom right */
        //"cookieslist": false, /* Show the cookie list */
        
        //"showIcon": true, /* Show cookie icon to manage cookies */
        // "iconSrc": "", /* Optionnal: URL or base64 encoded image */
        //"iconPosition": "BottomRight", /* Position of the icon between BottomRight, BottomLeft, TopRight and TopLeft */

        //"adblocker": false, /* Show a Warning if an adblocker is detected */

        //"DenyAllCta" : true, /* Show the deny all button */
        //"AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
        //"highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */

        //"handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

        //"removeCredit": false, /* Remove credit link */
        //"moreInfoLink": true, /* Show more info link */
        //"useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */

        //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for subdomain website */

        //"readmoreLink": "", /* Change the default readmore link pointing to tarteaucitron.io */
        
        //"mandatory": true /* Show a message about mandatory cookies */
   // });
</script>
@include('includes.toaster')
</html>
