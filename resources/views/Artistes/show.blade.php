@extends('layouts.app')

@section('content')
    @isset($artiste)
        <div id="header-container" style="background:url('{{ $artisteDb->profil_image }}');height:200px;width:100%;margin-top:0px !important;" data-img-url="{{ $artiste['image'][2]['#text'] }}">
            <div id="artiste-text-info" class="container-fluid" style="display:flex;justify-content:space-between;">
                <div class="mg-t-20" style="display:flex;flex-direction:column;">
                    <span class="barlow-font bolder-text" style="color:white;font-size:48px;">{{ $artiste['name'] }}</span>
                </div>
                <div id="container-cover" style="display:flex; justify-content:flex-end; margin-left:20px;">
                    {{-- <span style="display:inline-block;"> --}}
                        <img id="cover" crossorigin="anonymous" width="300px" height="300px;" src="{{ asset(!isset($artisteDb->profil_image) ? $artiste['image'][5]['#text'] : $artisteDb->profil_image) }}" alt="Image artiste"/>
                    {{-- </span> --}}
                </div>
            </div>

            @isset($artisteDb)
                @admin
                    <!-- Modification photo de l'artiste -->
                    <div class="shadow mg-l-20" style="width:50%;"> 
                        <span class="bolder-text text-20">Informations artistes</span>
                        <hr>
                        <form action="{{ route('artistes.update',$artisteDb->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="inputFileArtiste">Changer la photo de l'artiste :</label>
                                <input id="inputFileArtiste" type="file" name="profil_image" required/>
                            </div>
                            <button class="btn btn-success btn-sm"><i class="fas fa-check mg-r-5"></i>Valider</button>
                        </form>
                    </div>
                @endadmin

                <!-- Discographie -->
                <div id="content" class="shadow mg-l-20 mg-t-20">
                    <span class="bolder-text text-20">Discographie</span>
                    <hr>
                    @foreach($artisteDb->albums as $album)
                        <div class="mg-t-10 mg-b-5 light-dark">
                            <a href="{{ route('album.show',['artist'=> $album->artiste->nom,'album' => $album->nom]) }}" class="d-space-between d-align-center">
                                <div>
                                    <img src="{{ asset($album->cover[2]['#text']) }}" rel="Cover de l'album {{ $album->nom }}" style="width:80px; border-radius:10px;"/> 
                                    <span class="text-20 mg-l-10">{{ $album->nom }}</span>
                                </div>
                                <div>
                                    <div>
                                        <svg viewBox="0 0 1000 200" class='rating' style="width:100px;">
                                                                    <defs>
                                                                    
                                            <polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 "/>
                                                        
                                                                    <clipPath id="stars">
                                                                        <use xlink:href="#star"/>
                                                                        <use xlink:href="#star" x="20%"/>
                                                                        <use xlink:href="#star" x="40%"/>
                                                                        <use xlink:href="#star" x="60%"/>
                                                                        <use xlink:href="#star" x="80%"/>
                                                                    </clipPath>
                                                        
                                                                    </defs>
                                                                
                                            <rect class='rating__background' clip-path="url(#stars)"></rect>
                                        
                                            <!-- Rating value -->
                                            <rect width="{{ $album->average_notation*10 }}%" class='rating__value' clip-path="url(#stars)"></rect>
                                        
                                        </svg>
                                    </div>
                                    <div class="text-right mg-t-5">
                                        <span class="bolder-text">{{ $album->average_notation }} / 10</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Anectodes -->
                <div class="shadow mg-l-20 mg-t-20">
                    <span class="bolder-text text-20">Anectodes</span>
                    <hr>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAnectodeModal"><i class="fas fa-history mg-r-5"></i>Créer une anectode</button>
                    @if($artisteDb->anectodes->count() > 0)
                        <!-- TODO -->
                    @else
                        <div class="text-center flex-column mg-t-20 mg-b-20">
                            <i class="fas fa-comment-slash fa-3x"></i>
                            <span class="mg-t-10 italic-text">Aucune anectode</span>
                        </div>
                    @endif
                </div>

                <x-modal id="addAnectodeModal" title="Créer une nouvelle anectode">

                    <div class="alert alert-info">
                        <h5><i class="fas fa-question-circle mg-r-10" style="color:inherit;"></i>A quoi servent les anectodes ?</h5>
                        Une fois votre anectode certifié, vous gagnerez des points d'artiste, vous permettant de faire valoir votre connaissance sur l'artiste. 
                        <br>Un classement des meilleurs fans sera établis par artiste.
                    </div>
                </x-modal>
            @endisset
    @endisset
@endsection