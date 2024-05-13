@extends('layouts.app')

@section('content')
    <div class="raw">
        <div class="card">
            @if (count($EpisodeList) > 0)
                <div class="card-body text-center">
                    <button class="rambutton btn btn-lg btn-danger m-3" onclick="CleanDatabase()">Adatok ürítése</button>
                </div>
                <div class="card-header">
                    @include('RickAndMorty.listFilters')
                </div>
                <div class="card-body">
                    @include('RickAndMorty.listDetail')
                </div>
            @else
                <div class="card-header text-center">
                    <h3><b>Nem találhatóak Rick és Morty epizód adatok</b></h3>
                </div>
                <div class="card-body text-center">
                    <button class="rambutton btn btn-lg btn-success m-3" onclick="StartSync()">Adatok
                        szinkronizálása</button>
                    <a class="rambutton btn btn-lg btn-success m-3" href="/rickandmorty/init" onclick=HideButtons()>Ugrás
                        adatok szinkron
                        URL-re</a>
                </div>
                <div class="rambuttonstatus text-center d-none">
                    <p class="fs-1"><b>Az adatok szinkronizálása folyamatban!</b></p>
                    <p class="fs-5">Ez eltarthat néhány másodpercig, kérlek várj türelemmel.</p>
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only">Szinkron folyamatban...</span>
                        </div>
                </div>
            @endif
        </div>
    </div>
@endsection
