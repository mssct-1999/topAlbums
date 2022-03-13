@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="main-title mg-t-30">Bienvenue {{ Auth::user()->name }} !</h1>
    <div class="mg-t-50">
        <h1 class="main-title mg-b-20">Classement</h1>
        <div id="classement" class="text-center">
            <div class="flex-column d-align-center mg-t-40">
                <span class="   italic-text text-20">Chargement du classement en cours...</span>
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
