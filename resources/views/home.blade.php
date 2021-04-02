@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="main-title mg-t-30">Bienvenue {{ Auth::user()->name }} !</h1>
    <!-- todo -->
    <h1 class="main-title mg-t-100">Classement</h1>
</div>
@endsection
