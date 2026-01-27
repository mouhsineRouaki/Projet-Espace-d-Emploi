<?php

use Dom\Text;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(){
    Schema::create('users' , function(Blueprint $table){
        $table->id();
        $table->string('nom' , 50);
        $table->string('prenom',50);
        $table->string('email' , 100)->unique();
        $table->string('password' , 200);
        $table->text('biographie')->nullable();
        $table->string('image')->nullable();
        $table->enum('role' , ['RECRUTEUR' , 'RECHERCHEUR']);
        $table->timestamp('date_creation')->useCurrent();
        $table->timestamp('date_modification')->useCurrent();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
