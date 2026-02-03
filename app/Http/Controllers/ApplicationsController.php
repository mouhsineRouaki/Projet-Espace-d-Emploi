<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationsController extends Controller
{
    public function accept(Request $request, Application $application)
    {
        // Optionnel: sécuriser => seul le recruteur de l’offre peut accepter
        // abort_if($application->offer->user_id !== $request->user()->id, 403);

        $application->update(['status' => 'ACCEPTED']);

        return back()->with('success', 'Candidature acceptée.');
    }
}
