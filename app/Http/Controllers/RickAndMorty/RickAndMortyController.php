<?php

namespace App\Http\Controllers\RickAndMorty;

use App\Http\Controllers\Controller;
use App\Interfaces\RickAndMorty\RickAndMortyInterface;
use App\Models\RickAndMorty\Characters;
use App\Models\RickAndMorty\Episodes;
use App\Models\RickAndMorty\EpisodesCharacters;
use App\Models\RickAndMorty\Locations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RickAndMortyController extends Controller implements RickAndMortyInterface
{

    function List()
    {
        try {
            $EpisodeList = Episodes::all();

            return view('RickAndMorty.list', compact(array_keys(get_defined_vars())));
        } catch (Exception $exception) {
            return response()->json([
                'error' => '1',
                'errormessage' => $exception->getMessage(),
            ], 404);
        }
    }

    /**
     * A adatbázis táblák felötlésének elindítása
     */
    function InitData()
    {
        try {
            $RickAndMortyInitDataController = new RickAndMortyInitDataController;
            $RickAndMortyInitDataController->InitData();

            return $this->List();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * A adatbázis táblák ürítésének elindítása
     */
    function CleanDatabase()
    {
        try {
            $RickAndMortyInitDataController = new RickAndMortyInitDataController;
            $RickAndMortyInitDataController->CleanDatabase();

            return $this->List();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * A adatbázis táblák felötlésének elindítása
     */
    function InitDataURL()
    {
        try {
            if (!Characters::first() || !Episodes::first() || !Locations::first())
                $this->InitData();
            return $this->List();
        } catch (Exception $exception) {
            return response()->json([
                'error' => '1',
                'errormessage' => $exception->getMessage(),
            ], 404);
        }
    }

    /**
     * A adatbázis táblák felötlésének meghívása paranccsal
     */
    function InitDataCommand()
    {
        try {
            $this->InitData();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * A adatbázis táblák felötlésének meghívása Ajax hívással
     */
    function AjInitData(Request $request)
    {
        try {
            $this->InitData();

            return response()->json(['success' => 1, 'message' => 'Adatok szinkronizálása sikeres'], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => '1',
                'errormessage' => $exception->getMessage(),
            ], 404);
        }
    }

    /**
     * A adatbázis táblák ürítése Ajax hívással
     */
    function AjClearDatabase(Request $request)
    {
        try {
            $this->CleanDatabase();

            return response()->json(['success' => 1, 'message' => 'Adatok ürítése sikeres'], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => '1',
                'errormessage' => $exception->getMessage(),
            ], 404);
        }
    }


    /**
     * Vissza adja az adatott epizódban szereplő karakterek listáját megjeleníthető formában
     */
    function AjGetEpisodeCharacters(Request $request)
    {
        try {
            $episode = $request->episode;
            $CharacterList = EpisodesCharacters::with([
                'characterData' => [
                    'originData',
                    'locationData',
                ],
            ])->where('episode', $episode)->get();
            $html = view('RickAndMorty.character', compact(array_keys(get_defined_vars())))->render();

            return response()->json(['success' => 1, 'html' => $html], 200);
        } catch (Exception $exception) {
            return response()->json([
                'error' => '1',
                'errormessage' => $exception->getMessage(),
            ], 404);
        }
    }
}
