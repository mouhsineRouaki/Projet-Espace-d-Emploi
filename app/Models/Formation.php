<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Formation extends Model{
    use HasFactory;
    public function rechercheur(){
        return $this->belongsTo(\App\Models\Rechercheur::class, 'rechercheur_user_id', 'user_id');
    }

}
