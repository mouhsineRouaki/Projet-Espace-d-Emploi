<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rechercheur_skill', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rechercheur_user_id');
            $table->unsignedBigInteger('skill_id');

            $table->string('niveau', 30)->nullable();

            $table->timestamps();

            $table->foreign('rechercheur_user_id')->references('user_id')->on('rechercheurs')->cascadeOnDelete();
            $table->foreign('skill_id')->references('id')->on('skills')->cascadeOnDelete();

            $table->unique(['rechercheur_user_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rechercheur_skill');
    }
};
