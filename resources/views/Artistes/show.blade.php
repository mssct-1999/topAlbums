@extends('layouts.app')

@section('content')
    @isset($artiste)
        <div id="header-container" style="height:200px;width:100%;margin-top:0px !important;" data-img-url="{{ $artiste['image'][2]['#text'] }}">
            <div id="artiste-text-info" class="container-fluid" style="display:flex;justify-content:space-between;">
                <div class="mg-t-20" style="display:flex;flex-direction:column;">
                    <span class="barlow-font bolder-text" style="color:white;font-size:48px;">{{ $artiste['name'] }}</span>
                    {{-- @if(isset($artiste['bio']['published']))
                        <span class="barlow-font" style="color:white;">{{ $artiste['bio']['summary'] }}</span>
                    @endif --}}
                </div>
                <div id="container-cover" style="display:flex; justify-content:flex-end; margin-left:20px;">
                    <img id="cover" style="width:90%;" crossorigin="anonymous" src="{{ $artiste['image'][5]['#text'] }}" alt="Image artiste"/>
                </div>
            </div>
    @endisset
@endsection