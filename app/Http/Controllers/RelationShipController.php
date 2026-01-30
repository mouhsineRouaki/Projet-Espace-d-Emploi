<?php

namespace App\Http\Controllers;
use App\Models\RelationShip;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\FriendShipStatu;

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
    public function friendsPage(Request $request)
    {
        $me = $request->user();
        $q  = trim((string) $request->query('q', ''));

        $received = RelationShip::query()
            ->where('status', 'PENDING')
            ->where('reciever_id', $me->id)
            ->with('sender:id,nom,prenom,email,role,biographie,image')
            ->latest()
            ->get()
            ->map(fn ($rel) => $rel->sender)
            ->filter(); 

        $sent = RelationShip::query()
            ->where('status', 'PENDING')
            ->where('sender_id', $me->id)
            ->with('reciever:id,nom,prenom,email,role,biographie,image')
            ->latest()
            ->get()
            ->map(fn ($rel) => $rel->reciever)
            ->filter();

        $friendIds = RelationShip::query()
            ->where('status', 'ACCEPTED')
            ->where(function ($x) use ($me) {
                $x->where('sender_id', $me->id)
                  ->orWhere('reciever_id', $me->id);
            })
            ->get()
            ->map(fn ($rel) => $rel->sender_id == $me->id ? $rel->reciever_id : $rel->sender_id)
            ->unique()
            ->values()
            ->all();

        $friends = User::query()
            ->select('id','nom','prenom','email','role','biographie','image')
            ->whereIn('id', $friendIds)
            ->orderBy('nom')
            ->get();

        if ($q !== '') {
            $filterFn = fn ($u) =>
                str_contains(mb_strtolower($u->nom ?? ''), mb_strtolower($q)) ||
                str_contains(mb_strtolower($u->prenom ?? ''), mb_strtolower($q));

            $received = $received->filter($filterFn)->values();
            $sent     = $sent->filter($filterFn)->values();
            $friends  = $friends->filter($filterFn)->values();
        }

        return view('relationships.friends', compact('received', 'sent', 'friends', 'q'));
    }
    public function accepter(Request $request){
        $sender_id = $request->input('sender_id');
        $reciever_id  = $request->input('reciever_id');

        RelationShip::where('sender_id' , $sender_id)->where('status', 'PENDING')->where('reciever_id' , $reciever_id)->update(['status'=> 'ACCEPTED']);
        return  redirect()->route('friends.index');
    }
    public function refuser(Request $request){
        $sender_id = $request->input('sender_id');
        $reciever_id  = $request->input('reciever_id');

        RelationShip::where('sender_id' , $sender_id)->where('status', 'PENDING')->where('reciever_id' , $reciever_id)->update(['status'=> 'REFUSED']);
        return  redirect()->route('friends.index');
    }
}
