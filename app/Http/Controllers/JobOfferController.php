<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobOffer;

class JobOfferController extends Controller
{
    public function index(Request $request)
    {
        $me = $request->user();

        $offers = JobOffer::query()
            ->with('recruteur')
            ->where('recruteur_user_id', $me->id)
            ->latest()
            ->get();

        return view('offers.recruteur.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type_contrat' => ['required', 'string', 'max:50'],
            'titre'        => ['required', 'string', 'max:150'],
            'description'  => ['required', 'string'],
            'image'        => ['required', 'string', 'max:255'],
            'ville'        => ['nullable', 'string', 'max:80'],
        ]);

        JobOffer::create([
            'recruteur_user_id' => $request->user()->id,
            'type_contrat'      => $data['type_contrat'],
            'titre'             => $data['titre'],
            'description'       => $data['description'],
            'image'             => $data['image'],
            'ville'             => $data['ville'] ?? null,
            'is_closed'         => false,
            'closed_at'         => null,
        ]);

        return redirect()->route('offers.recruteur.index')->with('success', 'Offre créée ');
    }

    public function close(Request $request, JobOffer $offer)
    {
        abort_unless($offer->recruteur_user_id === $request->user()->id, 403);

        $offer->update([
            'is_closed' => true,
            'closed_at' => now(),
        ]);

        return redirect()->route('offers.recruteur.index')->with('success', 'Offre clôturée');
    }
    public function show(Request $request, JobOffer $offer)
    {
        $offer->load([
            'recruteur',
            'applications.rechercheur',
        ]);

        return view('offers.recruteur.show', compact('offer'));
    }
    public function acceptedApplicants(JobOffer $offer)
{
    $offer->load(['applications' => function ($q) {
        $q->where('status', 'ACCEPTED')
          ->latest()
          ->with('rechercheur');
    }]);

    return view('offers.recruteur.accepted', compact('offer'));
}
}
