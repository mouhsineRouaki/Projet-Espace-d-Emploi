<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rechercheur;
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
    public function detailsPage($id)
    {
        $user = User::query()->where('id', $id)->firstOrFail();

        $roleValue = is_object($user->role) ? ($user->role->value ?? $user->role->name ?? 'RECHERCHEUR') : ($user->role ?? 'RECHERCHEUR');

        $roleValue = strtoupper((string) $roleValue);

        if ($roleValue === 'RECRUTEUR') {
            return view('users.show', compact('user'));
        }

        $rechercheur = Rechercheur::with([
            'user',
            'formations' => fn ($q) => $q->orderByDesc('annee_obtention'),
            'experiences' => fn ($q) => $q->orderByDesc('date_debut'),
            'skills' => fn ($q) => $q->orderBy('nom'),
        ])->where('user_id', $user->id)->firstOrFail();

        return view('users.showRechercheur', compact('rechercheur'));
    }
    
}
