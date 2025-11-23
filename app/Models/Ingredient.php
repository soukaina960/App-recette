<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $fillable = ['nom', 'calories100g', 'protein100g', 'carbs100g', 'fat100g'];

    public function recettes()
    {
        return $this->belongsToMany(Recette::class, 'recette_ingredient')
                    ->withPivot('quantite')
                    ->withTimestamps();
    }
}
