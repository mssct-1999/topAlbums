@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-align-center">
        <img class="mg-t-20" @isset(Auth::user()->profil_image) src="{{ Auth::user()->profil_image }}" @else src="{{ secure_asset('img/default_picture_user.png') }}" @endisset style="width:70px;height:70px;border-radius:70px;"/>
        <h1 class="mg-t-30 mg-l-10">Bienvenue {{ Auth::user()->name }}</h1>
    </div>
    <div class="mg-t-50">
        <div class="mg-b-20">
            <h1 class="main-title"><i class="fas fa-trophy mg-r-5"></i>Classement</h1>
            <span class="text-10 italic-text">Pour des raisons de fluidité, ce classement est rafraîchi toutes les heures</span>
        </div>
        <div id="classement" class="text-center">
            <div class="flex-column d-align-center mg-t-40">
                <span class="   italic-text text-15">Chargement du classement en cours...</span>
                <div class="spinner-border text-primary mg-t-20" style="width: 5rem; height: 5rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ secure_asset('js/home.js') }}"></script>
@endpush
