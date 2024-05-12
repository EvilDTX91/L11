<?php

namespace App\Interfaces\RickAndMorty;

use Illuminate\Http\Request;

interface RickAndMortyInterface
{
    function List();
    function InitData();
    function CleanDatabase();
    function InitDataURL();
    function InitDataCommand();
    function AjInitData(Request $request);
    function AjClearDatabase(Request $request);
    function AjGetEpisodeCharacters(Request $request);
}
