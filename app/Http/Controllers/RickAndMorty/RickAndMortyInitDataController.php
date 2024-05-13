<?php

namespace App\Http\Controllers\RickAndMorty;

use App\Http\Controllers\Controller;
use App\Models\RickAndMorty\Characters;
use App\Models\RickAndMorty\Episodes;
use App\Models\RickAndMorty\EpisodesCharacters;
use App\Models\RickAndMorty\Locations;
use Exception;
use Illuminate\Support\Facades\Http;

class RickAndMortyInitDataController extends Controller
{
    private $DefaultURL = 'https://rickandmortyapi.com/api';
    private $ModelType; //characters, locations, episodes

    /**
     * Rick és Morty
     * Adatok feldolgozása és tárolása
     */
    function InitData()
    {
        try {
            $MainURLList = $this->GetDataFromURL($this->DefaultURL);
            foreach ($MainURLList as $key => $url) {
                $this->ModelType = $key;
                $this->ProcessedDataFromURL($url);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Összes RickAndMorty adatbázis tábla ürítése
     */
    function CleanDatabase()
    {
        try {
            EpisodesCharacters::truncate();
            Episodes::truncate();
            Locations::truncate();
            Characters::truncate();
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Az adatok feldolgozása és a tárolásuk meghívása
     * Ha az adatok infóban van következő oldal akkor a következő oldal URL-el meghívja önmagát
     * @param string $url #Az URL amit meghívunk, a vissza kapott adatokat feldogozzuk és tároljuk
     */
    private function ProcessedDataFromURL(string $url)
    {
        try {
            $data = $this->GetDataFromURL($url);
            foreach ($data->results as $result) {
                $this->StoreData($result);
            }
            if ($data->info->next)
                $this->ProcessedDataFromURL($data->info->next);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Az adat tárolása a típus alapján, a típus dönti el hogy melyik táblába kerül
     * @param object $NewRecord
     */
    private function StoreData(object $NewRecord)
    {
        try {
            if ($this->ModelType == 'characters') {
                $this->CreateCharacter($NewRecord);
            } else if ($this->ModelType == 'locations') {
                $this->CreateLocation($NewRecord);
            } else if ($this->ModelType == 'episodes') {
                $this->CreateEpisode($NewRecord);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Karakter tárolása adatbázisban
     * @param object $character
     */
    private function CreateCharacter(object $character)
    {
        try {
            $originid = $character->origin->name;
            if ($character->origin->url)
                $originid = $this->GetIdFromURLString($character->origin->url);

            $locationid = $character->location->name;
            if ($character->location->url)
                $locationid = $this->GetIdFromURLString($character->location->url);

            Characters::insertOrIgnore(
                [
                    'id' => $character->id,
                    'name' => $character->name,
                    'status' => $character->status,
                    'species' => $character->species,
                    'type' => $character->type,
                    'gender' => $character->gender,
                    'origin' => $originid,
                    'location' => $locationid,
                    'image' => $character->image,
                    'url' => $character->url,
                    'created' => $character->created
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Lokáció tárolása adatbázisban
     * @param object $location
     */
    private function CreateLocation(object $location)
    {
        try {
            Locations::insertOrIgnore(
                [
                    'id' => $location->id,
                    'name' => $location->name,
                    'type' => $location->type,
                    'dimension' => $location->dimension,
                    'url' => $location->url,
                    'created' => $location->created
                ]
            );
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Epizód tárolása adatbázisba
     * @param object $episode
     */
    private function CreateEpisode(object $episode)
    {
        try {
            Episodes::insertOrIgnore([
                'id' => $episode->id,
                'name' => $episode->name,
                'air_date' => $episode->air_date,
                'episode' => $episode->episode,
                'url' => $episode->url,
                'created' => $episode->created
            ]);
            $this->CreateEpisodeCharacters($episode->id, $episode->characters);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Az epizódban megjelenő karakterek tárolása adatbázisban
     * @param string $episode
     * @param array $characters
     */
    private function CreateEpisodeCharacters(string $episode, array $characters)
    {
        try {
            foreach ($characters as $characterURL) {
                $characterid = $this->GetIdFromURLString($characterURL);
                EpisodesCharacters::insertOrIgnore([
                    'episode' => $episode,
                    'character' => $characterid,
                ]);
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Vissza adja az URL végén található azonosítót
     * @param string $url
     * @return int $id
     */
    private function GetIdFromURLString(string $url)
    {
        try {
            $id = substr($url, strrpos($url, '/') + 1);
            return (int)$id;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * HTTP hívás indítása a megadott URL-re
     * A kapott adatok vissza adása objektumként
     * @param string $URL
     * @return object
     */
    private function GetDataFromURL(string $URL)
    {
        try {
            $response = Http::get($URL);

            return json_decode($response->body());
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
