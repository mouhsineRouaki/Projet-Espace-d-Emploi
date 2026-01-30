<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelationShip extends Model
{
    protected $table = 'relationships';
    protected $fillable = [
        'sender_id' , 'reciever_id' , 'status'
    ];
}
