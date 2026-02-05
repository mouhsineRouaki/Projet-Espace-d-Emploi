<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function searchPage(Request $request)
    {
        $q = $request->query('q'); 
        if(!empty($q)){
            $users = User::where('id' ,auth()->id())->where('nom', 'ILIKE', "%{$q}%")->orWhere('prenom', 'ILIKE', "%{$q}%")->get();
        }else{
            $users = User::where('id' ,'!=',auth()->id())->get();
        }
        return view('users.search', compact('users', 'q' ));
    }
    public function detailsPage($id){
    }
    
}
