<?php

namespace App\Models\RickAndMorty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Characters extends Model
{
    use HasFactory;

    /**
     * Get the origin associated with the Characters
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originData(): HasOne
    {
        return $this->hasOne(Locations::class, 'id', 'origin');
    }

    /**
     * Get the location associated with the Characters
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function locationData(): HasOne
    {
        return $this->hasOne(Locations::class, 'id', 'location');
    }

    /**
     * Get all of the episodes for the Characters
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(EpisodesCharacters::class, 'character', 'id');
    }
}
