<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recette_ingredients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recette_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->float('quantite'); // en grammes
            $table->timestamps();
            
            // Clé unique pour éviter les doublons
            $table->unique(['recette_id', 'ingredient_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('recette_ingredients');
    }
};