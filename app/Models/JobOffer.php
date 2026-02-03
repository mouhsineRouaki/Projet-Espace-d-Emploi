<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model{
    use HasFactory;

    protected $fillable = [
        'recruteur_user_id',
        'type_contrat',
        'titre',
        'description',
        'image',
        'ville',
        'is_closed',
        'closed_at',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'closed_at' => 'datetime',
    ];

    public function recruteur(){
        return $this->belongsTo(\App\Models\Recruteur::class, 'recruteur_user_id', 'user_id');
    }

    public function applications(){
        return $this->hasMany(\App\Models\Application::class, 'job_offer_id', 'id');
    }

}
