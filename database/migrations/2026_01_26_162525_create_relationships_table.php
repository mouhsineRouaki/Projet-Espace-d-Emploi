<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('reciever_id')->constrained('users');
            $table->enum('status', ['ACCEPTED', 'REFUSED', 'PENDING'])->default('PENDING');
            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_repond')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
