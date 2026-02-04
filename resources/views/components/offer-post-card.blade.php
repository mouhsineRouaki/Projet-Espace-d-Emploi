@props([
    'offer',
    'applied' => false,
])

@php
    $recruteur = $offer->recruiter;
    $recruteurName = trim(($recruteur->prenom ?? '').' '.($recruteur->nom ?? ($recruteur->name ?? 'Recruteur')));
    $recruteurImg = $recruteur->image ?? 'https://i.pravatar.cc/150?img=3';

    $isClosed = (bool) $offer->is_closed;
    $canApply = !$applied && !$isClosed;

    $desc = \Illuminate\Support\Str::limit($offer->description ?? '', 220);
@endphp

<article class="w-full rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="p-4 flex items-start gap-3">
        <img src="{{ $recruteurImg }}" class="h-11 w-11 rounded-full object-cover bg-slate-100" alt="">
        <div class="min-w-0 flex-1">
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="font-bold text-slate-900 truncate">{{ $recruteurName }}</p>
                    <p class="text-xs text-slate-500 truncate">
                        {{ $offer->type_contrat }}
                        @if($offer->ville) • {{ $offer->ville }} @endif
                        • {{ optional($offer->created_at)->diffForHumans() }}
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-700">
                        {{ $offer->type_contrat }}
                    </span>

                    @if($isClosed)
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-rose-50 text-rose-700 ring-1 ring-rose-200">
                            Clôturée
                        </span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                            Ouverte
                        </span>
                    @endif
                </div>
            </div>

            <h3 class="mt-3 text-lg font-black text-slate-900">
                {{ $offer->titre }}
            </h3>

            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                {{ $desc }}
            </p>
        </div>
    </div>

    <!-- Image -->
    @if($offer->image)
        <div class="bg-slate-100">
            <img src="{{ $offer->image }}" alt="{{ $offer->titre }}" class="w-full max-h-[420px] object-cover">
        </div>
    @endif

    <!-- Action -->
    <div class="p-4 border-t border-slate-200">
        <button
            type="button"
            wire:click="openApply({{ $offer->id }})"
            @disabled(!$canApply)
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-black transition
                {{ $canApply
                    ? 'bg-[#0a66c2] text-white hover:bg-blue-700'
                    : 'bg-slate-100 text-slate-400 cursor-not-allowed' }}"
        >
            @if($applied)
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Déjà postulé
            @elseif($isClosed)
                Offre clôturée
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14"/>
                </svg>
                Postuler
            @endif
        </button>
    </div>
</article>
