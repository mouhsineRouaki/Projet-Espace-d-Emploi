@props(['offer'])

@php
    $title = $offer->titre;
    $desc  = \Illuminate\Support\Str::limit($offer->description, 120);
    $ville = $offer->ville ?: '—';
    $type  = $offer->type_contrat;
    $img   = $offer->image;
    $isClosed = (bool) $offer->is_closed;

    $company = optional($offer->recruteur)->entreprise ?? 'Entreprise';
    $created = optional($offer->created_at)->format('d/m/Y') ?? '';
@endphp

<article class="group relative overflow-hidden rounded-[2rem] bg-white border border-slate-100 p-3
               transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)]">

    <!-- Cover image -->
    <div class="relative h-36 w-full rounded-[1.5rem] overflow-hidden">
        <img src="{{ $img }}" alt="{{ $title }}" class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent"></div>

        <div class="absolute top-3 left-3 flex gap-2">
            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-white/80 backdrop-blur border border-white/40 text-slate-800">
                {{ $type }}
            </span>

            @if($isClosed)
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-rose-500/90 text-white">
                    Clôturée
                </span>
            @else
                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider rounded-full bg-emerald-500/90 text-white">
                    Ouverte
                </span>
            @endif
        </div>
    </div>

    <!-- Body -->
    <div class="px-3 pt-4 pb-3">
        <div class="space-y-1">
            <h3 class="text-lg font-black text-slate-900 tracking-tight group-hover:text-indigo-600 transition-colors">
                {{ $title }}
            </h3>
            <div class="text-xs text-slate-500 font-semibold">
                {{ $company }} • {{ $ville }} • {{ $created }}
            </div>
        </div>

        <p class="mt-3 text-sm text-slate-600 leading-relaxed min-h-[3.5rem]">
            {{ $desc }}
        </p>

        <div class="mt-5 flex items-center gap-2">
            <!-- (optionnel) bouton détail si tu ajoutes offers.show plus tard -->
            <button type="button"
                    class="flex-1 rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-black text-slate-700 hover:bg-slate-50">
                Détails
            </button>

            @if(!$isClosed)
                <form method="POST" action="{{ route('offers.close', $offer->id) }}">
                    @csrf
                    <button type="submit"
                            class="rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-black text-white hover:bg-rose-600 transition">
                        Clôturer
                    </button>
                </form>
            @else
                <button disabled
                        class="rounded-2xl bg-slate-100 px-4 py-2.5 text-sm font-black text-slate-400 cursor-not-allowed">
                    Fermée
                </button>
            @endif
        </div>
    </div>

    <!-- Decorative glow -->
    <div class="pointer-events-none absolute -bottom-10 -right-10 h-32 w-32 rounded-full bg-indigo-200/30 blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
</article>
