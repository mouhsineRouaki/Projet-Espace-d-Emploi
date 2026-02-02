<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('recruteur_user_id');

            $table->string('type_contrat', 50);
            $table->string('titre', 150);
            $table->text('description');
            $table->string('image', 255);
            $table->string('ville', 80)->nullable();

            $table->boolean('is_closed')->default(false);
            $table->timestamp('closed_at')->nullable();

            $table->timestamps();

            $table->foreign('recruteur_user_id')->references('user_id')->on('recruteurs')->cascadeOnDelete();
            $table->index(['recruteur_user_id', 'is_closed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
