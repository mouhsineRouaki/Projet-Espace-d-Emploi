<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recruteurs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();

            $table->string('entreprise', 150);
            $table->string('site_web', 200)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->string('ville', 80)->nullable();
            $table->string('adresse', 255)->nullable();
            $table->text('description_entreprise')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void{
        Schema::dropIfExists('recruteurs');
    }
};
