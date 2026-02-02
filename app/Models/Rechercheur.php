<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rechercheur extends User
{
    use HasFactory;

    protected $table = 'rechercheurs';

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'titre_profil',
        'specialite',
        'ville',
        'cv_path',
    ];
    public function user(){
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function formations(){
        return $this->hasMany(\App\Models\Formation::class, 'rechercheur_user_id', 'user_id');
    }

    public function experiences(){
        return $this->hasMany(\App\Models\Experience::class, 'rechercheur_user_id', 'user_id');
    }

    public function applications(){
        return $this->hasMany(\App\Models\Application::class, 'rechercheur_user_id', 'user_id');
    }

    public function skills(){
        return $this->belongsToMany(
            \App\Models\Skill::class,
            'rechercheur_skill',
            'rechercheur_user_id',
            'skill_id'
        )->withPivot(['niveau'])->withTimestamps();
    }


}
