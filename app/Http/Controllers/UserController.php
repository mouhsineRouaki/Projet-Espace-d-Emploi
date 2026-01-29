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
        

        $user = User::findOrFail($id);
        $full = trim(($user->prenom ?? '').' '.($user->nom ?? ''));
        $role = $user->role?->value ?? 'RECHERCHEUR';
        $roleLabel = $role === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur';

        $theme = $role == 'RECRUTEUR'
            ? [
                'main' => 'indigo',
                'grad' => 'from-violet-600 to-indigo-600',
                'soft' => 'bg-violet-50 text-violet-700 ring-violet-200',
                'glow' => 'bg-violet-400/20',
                'btn'  => 'bg-violet-600 hover:bg-violet-700 shadow-violet-200'
              ]
            : [
                'main' => 'emerald',
                'grad' => 'from-teal-500 to-emerald-500',
                'soft' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
                'glow' => 'bg-emerald-400/20',
                'btn'  => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200'
              ];

        $initials = mb_strtoupper(mb_substr($user->prenom ?? 'U', 0, 1) . mb_substr($user->nom ?? 'U', 0, 1));
        $bio = $user->biographie ?: 'Aucune biographie disponible pour le moment.';
        $created = optional($user->created_at)->format('d/m/Y') ?? '—';
        return view('users.show', compact('user' , 'full' , 'role' , 'roleLabel' , 'theme' , 'initials' , 'bio' , 'created'));
    }
}
