<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Application extends Model{
    use HasFactory;
    protected $table = 'applications';
    protected $fillable = [
        'job_offer_id',
        'rechercheur_user_id',
        'status',
        'message',
    ];

    public function jobOffer(){
        return $this->belongsTo(\App\Models\JobOffer::class, 'job_offer_id', 'id');
    }

    public function rechercheur(){
        return $this->belongsTo(\App\Models\Rechercheur::class, 'rechercheur_user_id', 'user_id');
    }

}
