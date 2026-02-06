<?php

namespace App\Services;

use App\Models\JobOffer;
use App\Models\Rechercheur;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class McpApiService
{
    public function score(JobOffer $offer, Rechercheur $rechercheur): array
    {
        $rechercheur->loadMissing(['user', 'formations', 'experiences', 'skills']);

        $user = $rechercheur->user;

        $skillsText = $rechercheur->skills
            ->map(fn($s) => $s->nom . ($s->pivot?->niveau ? " ({$s->pivot->niveau})" : ''))
            ->implode(', ');

        $formationsText = $rechercheur->formations
            ->map(function ($f) {
                $year = $f->annee_obtention ? " ({$f->annee_obtention})" : '';
                return "{$f->diplome} - {$f->ecole}{$year}";
            })
            ->implode("\n");

        $experiencesText = $rechercheur->experiences
            ->map(function ($e) {
                $debut = $e->date_debut ? $e->date_debut : '';
                $fin = $e->en_poste ? 'Présent' : ($e->date_fin ?? '');
                $periode = trim($debut . ' - ' . $fin);
                return "{$e->poste} @ {$e->entreprise}" . ($periode ? " ({$periode})" : '');
            })
            ->implode("\n");

        $cvText = trim(implode("\n", array_filter([
            "Titre profil: " . ($rechercheur->titre_profil ?? ''),
            "Spécialité: " . ($rechercheur->specialite ?? ''),
            "Ville: " . ($rechercheur->ville ?? ''),
            "Bio: " . ($user->biographie ?? ''),
            $skillsText ? "Compétences: " . $skillsText : null,
            $formationsText ? "Formations:\n" . $formationsText : null,
            $experiencesText ? "Expériences:\n" . $experiencesText : null,
        ])));

        $offerText = trim(implode("\n", array_filter([
            "Titre: " . ($offer->titre ?? ''),
            "Type contrat: " . ($offer->type_contrat ?? ''),
            "Ville: " . ($offer->ville ?? ''),
            "Description: " . ($offer->description ?? ''),
        ])));

        // Si profil vraiment vide → impossible de scorer proprement
        if (Str::length($cvText) < 40 || Str::length($offerText) < 40) {
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        $system = <<<SYS
Tu fais un matching Candidat ↔ Offre.
Retourne UNIQUEMENT un JSON valide:
{
  "percentage": 0..100,
  "possiblePostule": true/false
}
Règles:
- percentage = score de correspondance globale.
- possiblePostule = true si score >= 35 ET informations suffisantes.
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
            'text' => [
                'format' => [
                    'type' => 'json_schema',
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
            Log::warning('OpenAI score failed', [
                'status' => $res->status(),
                'body' => $res->body(),
            ]);

            // fallback simple (keyword overlap)
            return $this->fallbackScore($offerText, $cvText);
        }

        $data = $res->json();
        $jsonText = null;

        foreach (($data['output'] ?? []) as $out) {
            foreach (($out['content'] ?? []) as $c) {
                if (($c['type'] ?? null) === 'output_text' && isset($c['text'])) {
                    $jsonText = $c['text'];
                    break 2;
                }
            }
        }

        $parsed = is_string($jsonText) ? json_decode($jsonText, true) : null;

        if (!is_array($parsed)) {
            return $this->fallbackScore($offerText, $cvText);
        }

        $percentage = max(0, min(100, (int) ($parsed['percentage'] ?? 0)));
        $possible = (bool) ($parsed['possiblePostule'] ?? false);

        // Garde-fou : si score élevé, on ne bloque pas bêtement
        if ($percentage >= 50) $possible = true;

        return [
            'percentage' => $percentage,
            'possiblePostule' => $possible,
        ];
    }

    private function fallbackScore(string $offerText, string $cvText): array
    {
        $offer = $this->tokens($offerText);
        $cv = $this->tokens($cvText);

        $common = array_intersect($offer, $cv);
        $ratio = count($offer) ? (count($common) / count($offer)) : 0;

        $percentage = (int) round(min(100, $ratio * 120)); // boost léger
        $possible = $percentage >= 35;

        return ['percentage' => $percentage, 'possiblePostule' => $possible];
    }

    private function tokens(string $text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^a-z0-9àâäéèêëîïôöùûüç\s]/ui', ' ', $text);
        $parts = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        $stop = ['de','la','le','les','des','du','un','une','et','ou','pour','avec','dans','sur','à','au','aux','en','ce','cet','cette','est','sont'];
        $parts = array_values(array_filter($parts, fn($w) => mb_strlen($w) >= 3 && !in_array($w, $stop)));

        return array_values(array_unique($parts));
    }
}
