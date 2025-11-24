<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->integer('age')->nullable();
        $table->float('weight')->nullable();      // poids en kg
        $table->float('height')->nullable();      // taille en cm
        $table->string('activity_level')->nullable(); // sedentaire, leger, etc.
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['age', 'weight', 'height', 'activity_level']);
    });
}

};
