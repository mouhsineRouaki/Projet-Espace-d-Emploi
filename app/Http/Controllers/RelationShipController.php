<?php

namespace App\Http\Controllers;
use App\Models\RelationShip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RelationShipController extends Controller
{
    public function AjouteAmi(Request $request)
    {
        $reciever_id = $request->input('reciever_id'); 

        RelationShip::firstOrCreate([
            'sender_id' => auth()->id(),
            'reciever_id' => $reciever_id,
        ], [
            'status' => 'PENDING'
        ]);

        return redirect()->route('users.search');
    }
}
