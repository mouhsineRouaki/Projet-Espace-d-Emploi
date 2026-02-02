<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruteur extends User
{
    use HasFactory;

    protected $table = 'recruteurs';

    // PK = user_id (pas id)
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'entreprise',
        'site_web',
        'telephone',
        'ville',
        'adresse',
        'description_entreprise',
    ];
}
