<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rechercheur_user_id');

            $table->string('diplome', 150);
            $table->string('ecole', 150);
            $table->year('annee_obtention')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('rechercheur_user_id')->references('user_id')->on('rechercheurs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
