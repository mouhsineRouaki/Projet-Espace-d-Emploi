<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rechercheurs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();

            $table->string('titre_profil', 150); // ex: Développeur Fullstack
            $table->string('specialite', 120);   // ex: Laravel, Comptable...
            $table->string('ville', 80)->nullable();
            $table->string('cv_path', 255)->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('specialite');
            $table->index('titre_profil');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rechercheurs');
    }
};
