<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model{
    use HasFactory;
    protected $table = 'skills';
    protected $fillable = [
        'nom'
    ];
    public function rechercheurs(){
        return $this->belongsToMany(
            \App\Models\Rechercheur::class,
            'rechercheur_skill',
            'skill_id',
            'rechercheur_user_id'
        )->withPivot(['niveau'])->withTimestamps();
    }

}
