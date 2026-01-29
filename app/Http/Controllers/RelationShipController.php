<?php

namespace App\Http\Controllers;
use App\Models\RelationsShip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelationShipController extends Controller
{
    public function AjouteAmi(Request $request){
        $reciever_id = $request->query('reciever_id');
        RelationsShip::create(['sender_id'=>auth()->id() , 'reciever_id'=> $reciever_id]);

    }
}
