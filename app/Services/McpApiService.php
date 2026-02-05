<?php

namespace App\Services;

use App\Models\JobOffer;
use App\Models\Rechercheur;
use Illuminate\Support\Facades\Http;

class McpApiService
{
    public function score(JobOffer $offer, Rechercheur $rechercheur): array
    {
        $user = $rechercheur->user; // Rechercheur->user relation

        // Texte CV (simple). Si tu as cv_text, utilise-le ici.
        $cvText = trim(implode("\n", array_filter([
            "Titre profil: ".$rechercheur->titre_profil,
            "Spécialité: ".$rechercheur->specialite,
            "Ville: ".($rechercheur->ville ?? ''),
            "Bio: ".($user->biographie ?? ''),
            "CV path: ".($rechercheur->cv_path ?? ''),
        ])));

        $offerText = trim(implode("\n", array_filter([
            "Titre: ".$offer->titre,
            "Type contrat: ".$offer->type_contrat,
            "Ville: ".($offer->ville ?? ''),
            "Description: ".$offer->description,
            "Clôturée: ".($offer->is_closed ? 'oui' : 'non'),
        ])));

        $system = <<<SYS
Tu fais un matching CV ↔ Offre.
Retourne UNIQUEMENT un JSON valide:
{
  "percentage": 0..100,
  "possiblePostule": true/false
}
Règles:
- percentage: 0 si aucune correspondance.
- possiblePostule: false si infos insuffisantes ou mismatch évident.
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
            return ['percentage' => 0, 'possiblePostule' => false];
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
            return ['percentage' => 0, 'possiblePostule' => false];
        }

        return [
            'percentage' => max(0, min(100, (int)($parsed['percentage'] ?? 0))),
            'possiblePostule' => (bool)($parsed['possiblePostule'] ?? false),
        ];
    }
}
