<?php

use App\Http\Controllers\RickAndMorty\RickAndMortyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web'])->group(function () {
    Route::get('/rickandmorty', [RickAndMortyController::class, 'List'])->name('List');
    Route::get('/rickandmorty/init', [RickAndMortyController::class, 'InitDataURL'])->name('InitDataURL');
    Route::post('/rickandmorty/init', [RickAndMortyController::class, 'AjInitData'])->name('AjInitData');
    Route::post('/rickandmorty/database/clear', [RickAndMortyController::class, 'AjClearDatabase'])->name('AjClearDatabase');
    Route::post('/rickandmorty/episode/characters', [RickAndMortyController::class, 'AjGetEpisodeCharacters'])->name('AjGetEpisodeCharacters');
});
