<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model{
    use HasFactory;
     
    public function user(){
        return $this->belongsTo(\App\Model\User::class , 'id','user_id' );
    }
}
