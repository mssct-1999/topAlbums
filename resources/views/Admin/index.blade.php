@extends('layouts.app')

@section('content')
    <div class="container-fluid mg-t-20" style="padding:30px;">
        <h1><i class="fas fa-chart-line mg-r-10"></i>Statistiques</h1>
        <hr>
        <div class="row">
            <!-- Statistiques inscriptions -->
            <x-panel title="Inscriptions" icon="fas fa-user fa-2x" class="col-md-5 mg-l-10 shadow"> 
                <div class="flex-column">
                    <div>
                        <i class="fas fa-calendar-day mg-r-5"></i>Aujourd'hui : 
                        <span class="bolder-text">
                            {{ $inscriptions->today }} inscription(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $inscriptions->diffToday >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($inscriptions->diffToday) par rapport à hier</span>
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-calendar-week mg-r-5"></i>Cette semaine : 
                        <span class="bolder-text">
                            {{ $inscriptions->week }} inscription(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $inscriptions->diffWeek >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($inscriptions->diffWeek) par rapport à la semaine dernière</span>
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-calendar mg-r-5"></i>Cette année : 
                        <span class="bolder-text">
                            {{ $inscriptions->year }} inscription(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $inscriptions->diffYear >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($inscriptions->diffYear) par rapport l'année dernière</span>
                        </span>
                    </div>
                    <div class="mg-t-10">
                        Au total : <span class="bolder-text">{{ $inscriptions->total }} inscriptions</span>
                    </div>
                </div>
            </x-panel>

            <!-- Statistiques commentaires -->
            <x-panel title="Activités commentaires" icon="fas fa-comments fa-2x" class="col-md-6 mg-l-10 shadow"> 
                <div class="flex-column">
                    <div>
                        <i class="fas fa-calendar-day mg-r-5"></i>Aujourd'hui : 
                        <span class="bolder-text">
                            {{ $commentaires->today }} commentaire(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $commentaires->diffToday >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($commentaires->diffToday) par rapport à hier</span>
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-calendar-week mg-r-5"></i>Cette semaine : 
                        <span class="bolder-text">
                            {{ $commentaires->week }} commentaire(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $commentaires->diffWeek >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($commentaires->diffWeek) par rapport à la semaine dernière</span>
                        </span>
                    </div>
                    <div>
                        <i class="fas fa-calendar mg-r-5"></i>Cette année : 
                        <span class="bolder-text">
                            {{ $commentaires->year }} commentaire(s)
                            <span class="italic-text mg-l-10 text-11" style="color:{{ $commentaires->diffYear >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($commentaires->diffYear) par rapport à l'année dernière</span>
                        </span>
                    </div>
                    <div class="mg-t-10">
                        Au total : <span class="bolder-text">{{ $commentaires->total }} commentaires</span>
                    </div>
                </div>
            </x-panel>
        </div>
        
        <!-- Statistiques votes -->
        <div class="row mg-t-10">
            <x-panel title="Votes" icon="fas fa-poll fa-2x" class="col-md-11 mg-l-10 shadow"> 
                <div class="d-space-between">
                    
                    <div class="flex-column">
                        <div>
                            <i class="fas fa-calendar-day mg-r-5"></i>Aujourd'hui : 
                            <span class="bolder-text">
                                {{ $votes->today }} vote(s)
                                <span class="italic-text mg-l-10 text-11" style="color:{{ $votes->diffToday >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($votes->diffToday) par rapport à hier</span>
                            </span>
                        </div>
                        <div>
                            <i class="fas fa-calendar-week mg-r-5"></i>Cette semaine : 
                            <span class="bolder-text">
                                {{ $votes->week }} vote(s)
                                <span class="italic-text mg-l-10 text-11" style="color:{{ $votes->diffWeek >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($votes->diffWeek) par rapport à la semaine dernière</span>
                            </span>
                        </div>
                        <div>
                            <i class="fas fa-calendar mg-r-5"></i>Cette année : 
                            <span class="bolder-text">
                                {{ $votes->year }} vote(s)
                                <span class="italic-text mg-l-10 text-11" style="color:{{ $votes->diffWeek >= 0 ? '#1ED760' : '#C4105A' }};font-weight:normal;">@comparaison($votes->diffYear) par rapport à l'année dernière</span>
                            </span>
                        </div>
                        <div class="mg-t-10">
                            Au total : <span class="bolder-text">{{ $votes->total }} votes</span>
                        </div>
                    </div>

                    <div style="display:flex;flex-direction:row;justify-content:space-around;">
                        <div class="mg-r-50">
                            <span class="bolder-text">Utilisateur le plus actif</span>
                            <div class="mg-t-10">
                                <img src="{{ secure_asset($votes->mostActiveUser->profil_image) }}" style="width:70px;border-radius:70px;"/>
                                <span class="mg-l-10">{{ $votes->mostActiveUser->name }} - {{ $votes->mostActiveUser->nb_votes }} votes</span>
                            </div>
                        </div>
                        <div>
                            <span class="bolder-text">Album avec le plus de votes</span>
                            <div class="mg-t-10 d-align-center">
                                <img src="{{ \App\LastFMAPIHelper::getCoverAlbum($votes->mostVotedAlbum->artiste,$votes->mostVotedAlbum->nom)[1]['#text'] }}" style="width:70px;border-radius:70px;"/>
                                <div class="flex-column">
                                    <span class="mg-l-10">{{ $votes->mostVotedAlbum->nom }} - {{ $votes->mostVotedAlbum->nb_votes }} votes</span>
                                    <span class="mg-l-10 italic-text">{{ $votes->mostVotedAlbum->artiste }}</span>
                                </div>
                            </div>
                        </div>  
                    </div>

                </div>
            </x-panel>
        </div>
        <!-- TODO - chart  -->

        <!-- Recherche d'utilisateurs  -->
        <h1><i class="fas fa-id-card-alt mg-r-10 mg-t-50"></i>Rechercher un compte</h1>
        <hr>
        <div class="form-row">
            <div class="col">
                <label>Pseudo :</label>
                <input id="usernameInput" class="form-control form-control-sm" name="username">
            </div>
        </div>
        <button id="searchUserAdminButton" class="btn btn-success btn-sm mg-t-10"><i class="fas fa-check mg-r-5"></i>Valider</button>
        <div id="resultQuery" class="mg-t-20"></div>
    </div>
@endsection

@push('js')
    <script src="{{ secure_asset('js/admin.js') }}"></script>
@endpush