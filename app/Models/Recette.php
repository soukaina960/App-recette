<?php
// app/Models/Ingredient.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recette extends Model
{
    protected $fillable = ['nom', 'description'];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recette_ingredient')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}
