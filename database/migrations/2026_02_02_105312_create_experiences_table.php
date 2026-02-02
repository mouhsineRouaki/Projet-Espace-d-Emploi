<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rechercheur_user_id');

            $table->string('poste', 150);
            $table->string('entreprise', 150);
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->boolean('en_poste')->default(false);
            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('rechercheur_user_id')->references('user_id')->on('rechercheurs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
