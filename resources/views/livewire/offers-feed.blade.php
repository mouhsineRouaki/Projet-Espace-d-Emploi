<div class="space-y-5">

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters (search + selects) -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-4">
        <div class="grid gap-3 md:grid-cols-4">
            <div class="md:col-span-2">
                <label class="text-xs font-black uppercase tracking-wider text-slate-500">Recherche</label>
                <input
                    type="text"
                    wire:model.live="q"
                    placeholder="Titre, ville, mots-clés..."
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]"
                />
            </div>

            <div>
                <label class="text-xs font-black uppercase tracking-wider text-slate-500">Type</label>
                <select
                    wire:model.live="type"
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]"
                >
                    <option value="">Tous</option>
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Full-time">Full-time</option>
                    <option value="Stage">Stage</option>
                    <option value="Freelance">Freelance</option>
                </select>
            </div>

            <div>
                <label class="text-xs font-black uppercase tracking-wider text-slate-500">Ville</label>
                <input
                    type="text"
                    wire:model.live="ville"
                    placeholder="Casablanca..."
                    class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]"
                />
            </div>

            <div class="md:col-span-4 flex items-center justify-between pt-1">
                <label class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" wire:model.live="openOnly" class="rounded border-slate-300 text-[#0a66c2] focus:ring-[#0a66c2]">
                    Offres ouvertes seulement
                </label>

                <button wire:click="$set('q',''); $set('type',''); $set('ville',''); $set('openOnly', true)"
                        class="text-sm font-black text-slate-700 hover:text-slate-900">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Feed -->
    <div class="max-w-3xl mx-auto space-y-5">
        @forelse($offers as $offer)
            <x-offer-post-card
                :offer="$offer"
                :applied="in_array($offer->id, $appliedOfferIds, true)"
            />
        @empty
            <div class="rounded-2xl bg-white border border-slate-200 p-8 text-center text-slate-600">
                Aucune offre trouvée.
            </div>
        @endforelse

        @if(count($offers) >= $perPage)
            <button wire:click="loadMore"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-black text-slate-800 hover:bg-slate-50">
                Charger plus
            </button>
        @endif
    </div>

    <!-- Modal Postuler -->
    @if($showApplyModal && $selectedOffer)
        <div class="fixed inset-0 z-[80] flex items-center justify-center p-4" wire:click.self="closeApply">
            <div class="absolute inset-0 bg-slate-900/50"></div>

            <div class="relative w-full max-w-2xl rounded-2xl bg-white border border-slate-200 shadow-2xl overflow-hidden">
                <div class="p-5 border-b border-slate-200 flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Postuler</h3>
                        <p class="text-sm text-slate-500">
                            {{ $selectedOffer->titre }} • {{ $selectedOffer->type_contrat }}
                            @if($selectedOffer->ville) • {{ $selectedOffer->ville }} @endif
                        </p>
                    </div>

                    <button wire:click="closeApply" class="p-2 rounded-xl hover:bg-slate-100 text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="apply" class="p-5 space-y-3">
                    <div>
                        <label class="text-sm font-bold text-slate-700">Message (optionnel)</label>
                        <textarea
                            wire:model.defer="message"
                            rows="5"
                            placeholder="Écris un petit message au recruteur..."
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#0a66c2] focus:border-[#0a66c2]"
                        ></textarea>
                        @error('message') <p class="mt-1 text-xs font-bold text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeApply"
                                class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-black text-slate-700 hover:bg-slate-50">
                            Annuler
                        </button>

                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="rounded-xl bg-[#0a66c2] px-5 py-2.5 text-sm font-black text-white hover:bg-blue-700">
                            Postuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
