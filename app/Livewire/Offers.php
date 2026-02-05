<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobOffer;
use App\Models\Application;

class Offers extends Component
{
    public string $q = '';
    public string $type = '';
    public string $ville = '';
    public bool $openOnly = true;

    public int $perPage = 6;

    // Modal postuler
    public bool $showApplyModal = false;
    public ?JobOffer $selectedOffer = null;
    public string $message = '';

    // Liste des offres déjà postulées par user connecté
    public array $appliedOfferIds = [];

    public function mount()
    {
        $this->refreshAppliedIds();
    }

    private function refreshAppliedIds(): void
    {
        if (!auth()->check()) {
            $this->appliedOfferIds = [];
            return;
        }

        $this->appliedOfferIds = Application::query()
            ->where('rechercheur_user_id', auth()->id())
            ->pluck('job_offer_id')
            ->all();
    }

    public function updatedQ() { $this->resetList(); }
    public function updatedType() { $this->resetList(); }
    public function updatedVille() { $this->resetList(); }
    public function updatedOpenOnly() { $this->resetList(); }

    private function resetList(): void
    {
        $this->perPage = 6;
    }

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    public function openApply(int $offerId): void
    {
        if (!auth()->check()) return;

        // déjà postulé => rien faire
        if (in_array($offerId, $this->appliedOfferIds, true)) return;

        // offre ouverte seulement
        $offer = JobOffer::query()
            ->with('recruteur.user')
            ->whereKey($offerId)
            ->where('is_closed', false)
            ->firstOrFail();

        $this->selectedOffer = $offer;
        $this->message = '';
        $this->resetErrorBag();
        $this->showApplyModal = true;
    }

    public function closeApply(): void
    {
        $this->showApplyModal = false;
        $this->selectedOffer = null;
        $this->message = '';
        $this->resetErrorBag();
    }

    public function apply(): void
    {
        if (!auth()->check() || !$this->selectedOffer) return;

        $this->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        $offerId = $this->selectedOffer->id;

        // sécurité si double clic
        if (in_array($offerId, $this->appliedOfferIds, true)) {
            $this->closeApply();
            return;
        }

        Application::create([
            'job_offer_id' => $offerId,
            'rechercheur_user_id' => auth()->id(),
            'status' => 'PENDING',
            'message' => $this->message,
        ]);

        $this->refreshAppliedIds();
        $this->closeApply();

        session()->flash('success', 'Candidature envoyée ✅');
    }

    public function render()
    {
        $offers = JobOffer::query()
            ->with('recruteur.user')
            ->when($this->openOnly, fn($q) => $q->where('is_closed', false))
            ->when($this->type, fn($q) => $q->where('type_contrat', $this->type))
            ->when($this->ville, fn($q) => $q->where('ville', 'ILIKE', "%{$this->ville}%"))
            ->when($this->q, function($q) {
                $term = $this->q;
                $q->where(function($qq) use ($term) {
                    $qq->where('titre', 'ILIKE', "%{$term}%")
                       ->orWhere('description', 'ILIKE', "%{$term}%")
                       ->orWhere('ville', 'ILIKE', "%{$term}%");
                });
            })
            ->orderByDesc('created_at')
            ->take($this->perPage)
            ->get();

        return view('livewire.offers-rechercheurs', [
            'offers' => $offers,
        ]);
    }
}
