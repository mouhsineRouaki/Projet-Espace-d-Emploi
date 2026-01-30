<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class RelationShip extends Model
{
    protected $table = 'relationships';
    protected $fillable = [
        'sender_id' , 'reciever_id' , 'status'
    ];
    public function sender()   { return $this->belongsTo(User::class, 'sender_id'); }
    public function reciever() { return $this->belongsTo(User::class, 'reciever_id'); }
}
