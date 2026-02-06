<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Formation;
use App\Models\Rechercheur;
use App\Models\Skill;
use Illuminate\Http\Request;

class RechercheurProfileController extends Controller
{
    public function edit(Request $request)
    {
        $u = $request->user();

        $u->load([
            'rechercheur.formations',
            'rechercheur.experiences',
            'rechercheur.skills',
        ]);

        return view('rechercheur.profile.edit', compact('u'));
    }

    public function update(Request $request)
    {
        $u = $request->user();

        $roleValue = is_object($u->role)
            ? ($u->role->value ?? $u->role->name ?? 'RECHERCHEUR')
            : ($u->role ?? 'RECHERCHEUR');
        $roleValue = strtoupper((string) $roleValue);

        $rules = [
            'nom' => ['required', 'string', 'max:50'],
            'prenom' => ['required', 'string', 'max:50'],
            'biographie' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:RECHERCHEUR,RECRUTEUR'],
        ];

        if ($request->input('role') === 'RECHERCHEUR') {
            $rules = array_merge($rules, [
                'titre_profil' => ['required', 'string', 'max:150'],
                'specialite' => ['required', 'string', 'max:120'],
                'ville' => ['nullable', 'string', 'max:80'],
                'cv_path' => ['nullable', 'string', 'max:255'],
            ]);
        }

        $data = $request->validate($rules);

        $u->update([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'biographie' => $data['biographie'] ?? null,
            'image' => $data['image'] ?? null,
            'role' => $data['role'],
        ]);
        if ($data['role'] === 'RECHERCHEUR') {
            Rechercheur::updateOrCreate(
                ['user_id' => $u->id],
                [
                    'titre_profil' => $data['titre_profil'],
                    'specialite' => $data['specialite'],
                    'ville' => $data['ville'] ?? null,
                    'cv_path' => $data['cv_path'] ?? null,
                ]
            );
        }

        return back()->with('status', 'Profil mis à jour ');
    }

    public function storeFormation(Request $request)
    {
        $u = $request->user();
        $rechercheur = Rechercheur::firstOrCreate(['user_id' => $u->id], [
            'titre_profil' => '—',
            'specialite' => '—',
        ]);

        $data = $request->validate([
            'diplome' => ['required', 'string', 'max:150'],
            'ecole' => ['required', 'string', 'max:150'],
            'annee_obtention' => ['nullable', 'digits:4'],
            'description' => ['nullable', 'string'],
        ]);

        $rechercheur->formations()->create($data);

        return back()->with('status', 'Formation ajoutée');
    }

    public function updateFormation(Request $request, Formation $formation)
    {
        abort_unless($formation->rechercheur_user_id === $request->user()->id, 403);

        $data = $request->validate([
            'diplome' => ['required', 'string', 'max:150'],
            'ecole' => ['required', 'string', 'max:150'],
            'annee_obtention' => ['nullable', 'digits:4'],
            'description' => ['nullable', 'string'],
        ]);

        $formation->update($data);

        return back()->with('status', 'Formation modifiée ');
    }

    public function destroyFormation(Request $request, Formation $formation)
    {
        abort_unless($formation->rechercheur_user_id === $request->user()->id, 403);
        $formation->delete();

        return back()->with('status', 'Formation supprimée ');
    }

    public function storeExperience(Request $request)
    {
        $u = $request->user();
        $rechercheur = Rechercheur::firstOrCreate(['user_id' => $u->id], [
            'titre_profil' => '—',
            'specialite' => '—',
        ]);

        $data = $request->validate([
            'poste' => ['required', 'string', 'max:150'],
            'entreprise' => ['required', 'string', 'max:150'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date'],
            'en_poste' => ['nullable'],
            'description' => ['nullable', 'string'],
        ]);

        $data['en_poste'] = $request->boolean('en_poste');
        if ($data['en_poste']) $data['date_fin'] = null;

        $rechercheur->experiences()->create($data);

        return back()->with('status', 'Expérience ajoutée');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        abort_unless($experience->rechercheur_user_id === $request->user()->id, 403);

        $data = $request->validate([
            'poste' => ['required', 'string', 'max:150'],
            'entreprise' => ['required', 'string', 'max:150'],
            'date_debut' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date'],
            'en_poste' => ['nullable'],
            'description' => ['nullable', 'string'],
        ]);

        $data['en_poste'] = $request->boolean('en_poste');
        if ($data['en_poste']) $data['date_fin'] = null;

        $experience->update($data);

        return back()->with('status', 'Expérience modifiée ');
    }

    public function destroyExperience(Request $request, Experience $experience)
    {
        abort_unless($experience->rechercheur_user_id === $request->user()->id, 403);
        $experience->delete();

        return back()->with('status', 'Expérience supprimée ✅');
    }

    // ------------------- SKILLS -------------------
    public function attachSkill(Request $request)
    {
        $u = $request->user();
        $rechercheur = Rechercheur::firstOrCreate(['user_id' => $u->id], [
            'titre_profil' => '—',
            'specialite' => '—',
        ]);

        $data = $request->validate([
            'skill_name' => ['required', 'string', 'max:120'],
            'niveau' => ['nullable', 'in:DEBUTANT,INTERMEDIAIRE,AVANCE,EXPERT'],
        ]);

        $skill = Skill::firstOrCreate(['nom' => trim($data['skill_name'])]);

        $rechercheur->skills()->syncWithoutDetaching([
            $skill->id => ['niveau' => $data['niveau'] ?? null],
        ]);

        return back()->with('status', 'Compétence ajoutée');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $u = $request->user();
        $rechercheur = Rechercheur::where('user_id', $u->id)->firstOrFail();

        $data = $request->validate([
            'niveau' => ['nullable', 'in:DEBUTANT,INTERMEDIAIRE,AVANCE,EXPERT'],
        ]);

        $rechercheur->skills()->updateExistingPivot($skill->id, [
            'niveau' => $data['niveau'] ?? null,
        ]);

        return back()->with('status', 'Niveau compétence modifié');
    }

    public function detachSkill(Request $request, Skill $skill)
    {
        $u = $request->user();
        $rechercheur = Rechercheur::where('user_id', $u->id)->firstOrFail();

        $rechercheur->skills()->detach($skill->id);

        return back()->with('status', 'Compétence supprimée');
    }
}
