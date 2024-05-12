<?php

namespace App\Models\RickAndMorty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locations extends Model
{
    use HasFactory;

    /**
     * Get all of the residents for the Locations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function residents(): HasMany
    {
        return $this->hasMany(Characters::class, 'location', 'id');
    }
}
