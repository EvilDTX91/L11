<?php

namespace App\Models\RickAndMorty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EpisodesCharacters extends Model
{
    use HasFactory;

    /**
     * Get the character that owns the EpisodesCharacters
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function characterData(): BelongsTo
    {
        return $this->belongsTo(Characters::class, 'character', 'id');
    }

    /**
     * Get the episode that owns the EpisodesCharacters
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function episodeData(): BelongsTo
    {
        return $this->belongsTo(Episodes::class, 'episode', 'id');
    }
}
