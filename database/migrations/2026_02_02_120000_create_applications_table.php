<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('job_offer_id');
            $table->unsignedBigInteger('rechercheur_user_id');

            $table->enum('status', ['PENDING', 'ACCEPTED', 'REFUSED'])->default('PENDING');
            $table->text('message')->nullable();

            $table->timestamps();

            $table->foreign('job_offer_id')->references('id')->on('job_offers')->cascadeOnDelete();
            $table->foreign('rechercheur_user_id')->references('user_id')->on('rechercheurs')->cascadeOnDelete();

            $table->unique(['job_offer_id', 'rechercheur_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
