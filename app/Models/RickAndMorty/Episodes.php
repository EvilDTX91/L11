<?php

namespace App\Models\RickAndMorty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Episodes extends Model
{
    use HasFactory;

    /**
     * Get all of the characters for the Episodes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function characters(): HasMany
    {
        return $this->hasMany(EpisodesCharacters::class, 'episode', 'id');
    }
}
