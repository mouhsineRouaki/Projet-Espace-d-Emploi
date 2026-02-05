<?php

namespace App\Services;

use App\Models\JobOffer;
use App\Models\Rechercheur;
use Illuminate\Support\Facades\Http;

class McpApiService
{
    public function score(JobOffer $offer, Rechercheur $rechercheur): array
    {
        $rechercheur->loadMissing(['user', 'formations', 'experiences', 'skills']);

        if ($offer->is_closed) {
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        $user = $rechercheur->user;

        $skillsLine = $rechercheur->skills
            ->map(fn ($s) => trim($s->nom . ($s->pivot?->niveau ? " ({$s->pivot->niveau})" : "")))
            ->filter()
            ->values()
            ->implode(', ');

        $formationsText = $rechercheur->formations
            ->sortByDesc('annee_obtention')
            ->map(function ($f) {
                $parts = array_filter([
                    $f->diplome ? "Diplôme: {$f->diplome}" : null,
                    $f->ecole ? "École: {$f->ecole}" : null,
                    $f->annee_obtention ? "Année: {$f->annee_obtention}" : null,
                    $f->description ? "Desc: " . $this->clean($f->description) : null,
                ]);
                return "- " . implode(' | ', $parts);
            })
            ->implode("\n");

        $experiencesText = $rechercheur->experiences
            ->sortByDesc('date_debut')
            ->map(function ($e) {
                $periode = trim(
                    ($e->date_debut ? $e->date_debut : '') .
                    ' → ' .
                    ($e->en_poste ? 'présent' : ($e->date_fin ? $e->date_fin : ''))
                );

                $parts = array_filter([
                    $e->poste ? "Poste: {$e->poste}" : null,
                    $e->entreprise ? "Entreprise: {$e->entreprise}" : null,
                    $periode ? "Période: {$periode}" : null,
                    $e->description ? "Desc: " . $this->clean($e->description) : null,
                ]);
                return "- " . implode(' | ', $parts);
            })
            ->implode("\n");

        $missing = [];
        if (!$this->hasText($rechercheur->titre_profil)) $missing[] = 'titre_profil';
        if (!$this->hasText($rechercheur->specialite)) $missing[] = 'specialite';
        if (!$this->hasText($user?->biographie)) $missing[] = 'biographie';
        if ($rechercheur->skills->isEmpty()) $missing[] = 'skills';

        if (count($missing) >= 3) {
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        $cvText = trim(implode("\n", array_filter([
            "Nom: " . trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')),
            "Titre profil: " . ($rechercheur->titre_profil ?? ''),
            "Spécialité: " . ($rechercheur->specialite ?? ''),
            "Ville: " . ($rechercheur->ville ?? ''),
            "Bio: " . $this->clean($user->biographie ?? ''),
            $skillsLine ? "Compétences: {$skillsLine}" : null,
            $formationsText ? "Formations:\n{$formationsText}" : null,
            $experiencesText ? "Expériences:\n{$experiencesText}" : null,
            $rechercheur->cv_path ? "CV path: {$rechercheur->cv_path}" : null,
        ])));

        $offerText = trim(implode("\n", array_filter([
            "Titre: " . ($offer->titre ?? ''),
            "Type contrat: " . ($offer->type_contrat ?? ''),
            "Ville: " . ($offer->ville ?? ''),
            "Description: " . $this->clean($offer->description ?? ''),
        ])));

        $system = <<<SYS
Tu fais un matching CV ↔ Offre.
Retourne UNIQUEMENT un JSON valide :
{
  "percentage": 0..100,
  "possiblePostule": true/false
}

Contraintes :
- percentage = 0 si aucune correspondance.
- possiblePostule = false si mismatch évident OU infos insuffisantes (profil vide, pas de skills/spécialité).
- Sois strict : ne mets pas 70+ si tu n’as pas des indices clairs (skills/expérience/spécialité alignés).
SYS;

        $userMsg = <<<USR
OFFRE:
{$offerText}

CANDIDAT:
{$cvText}
USR;

        $payload = [
            'model' => config('services.openai.model', 'gpt-4o-mini'),
            'input' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $userMsg],
            ],
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'offer_match',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'percentage' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
                            'possiblePostule' => ['type' => 'boolean'],
                        ],
                        'required' => ['percentage', 'possiblePostule'],
                        'additionalProperties' => false,
                    ],
                ],
            ],
        ];

        $res = Http::withToken(config('services.openai.key'))
            ->acceptJson()
            ->post('https://api.openai.com/v1/responses', $payload);

        if (!$res->ok()) {
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        $data = $res->json();
        $jsonText = $this->extractOutputText($data);
        $parsed = is_string($jsonText) ? json_decode($jsonText, true) : null;

        if (!is_array($parsed)) {
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        $percentage = max(0, min(100, (int)($parsed['percentage'] ?? 0)));
        $possible = (bool)($parsed['possiblePostule'] ?? false);

        $min = (int) config('mcp.min_percentage', 30);
        if ($percentage < $min) $possible = false;

        return ['percentage' => $percentage, 'possiblePostule' => $possible];
    }

    private function extractOutputText(array $data): ?string
    {
        foreach (($data['output'] ?? []) as $out) {
            foreach (($out['content'] ?? []) as $c) {
                if (($c['type'] ?? null) === 'output_text' && isset($c['text'])) {
                    return $c['text'];
                }
            }
        }
        return null;
    }

    private function hasText(?string $s): bool
    {
        return is_string($s) && trim($s) !== '';
    }

    private function clean(string $s): string
    {
        $s = preg_replace("/\s+/", " ", trim($s));
        return $s ?? '';
    }
}
