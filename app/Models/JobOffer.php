<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model{
    use HasFactory;
    public function recruteur(){
        return $this->belongsTo(\App\Models\Recruteur::class, 'recruteur_user_id', 'user_id');
    }

    public function applications(){
        return $this->hasMany(\App\Models\Application::class, 'job_offer_id', 'id');
    }

}
