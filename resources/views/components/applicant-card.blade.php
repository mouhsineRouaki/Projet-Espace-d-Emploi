@props([
    'href' => '#',
    'userId' => null,
    'applicationId' => null,

    'nom' => 'Nom',
    'prenom' => 'Prénom',
    'role' => 'RECHERCHEUR',
    'email' => 'email@exemple.com',
    'biographie' => 'Aucune biographie pour le moment',
    'image' => null,

    'status' => 'PENDING',   // PENDING | ACCEPTED | REFUSED
    'appliedAt' => null,
])

@php
    $full = trim($prenom.' '.$nom);

    $roleValue = is_object($role)
        ? ($role->value ?? $role->name ?? 'RECHERCHEUR')
        : ($role ?? 'RECHERCHEUR');

    $roleValue = strtoupper((string) $roleValue);
    $roleLabel = $roleValue === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur';

    $initials = mb_strtoupper(mb_substr($prenom ?: 'U', 0, 1).mb_substr($nom ?: 'U', 0, 1));
    $shortBio = \Illuminate\Support\Str::limit($biographie ?? 'Aucune biographie disponible.', 90);

    $status = strtoupper((string)$status);

    $statusBadge = match($status) {
        'ACCEPTED' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'REFUSED'  => 'bg-rose-50 text-rose-700 ring-rose-200',
        default    => 'bg-amber-50 text-amber-700 ring-amber-200',
    };

    $statusLabel = match($status) {
        'ACCEPTED' => 'Acceptée',
        'REFUSED'  => 'Refusée',
        default    => 'En attente',
    };

    $disabledAccept = $status !== 'PENDING';
@endphp

<article class="group relative max-w-sm w-full bg-white rounded-[2rem] border border-slate-100 p-3 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] hover:-translate-y-1">
    <div class="relative h-28 w-full rounded-[1.5rem] overflow-hidden bg-gradient-to-br from-slate-900 to-slate-700">
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, white, transparent 50%);"></div>

        <div class="absolute top-3 right-3 flex items-center gap-2">
            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/30">
                {{ $roleLabel }}
            </span>

            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full ring-1 {{ $statusBadge }}">
                {{ $statusLabel }}
            </span>
        </div>
    </div>

    <div class="relative px-4 pb-4">
        <div class="relative -mt-10 mb-3 flex items-end justify-between gap-3">
            <div class="h-20 w-20 rounded-3xl bg-white p-1.5 shadow-xl">
                <div class="h-full w-full rounded-2xl overflow-hidden bg-slate-100 border border-slate-50">
                    @if($image)
                        <img src="{{ $image }}" alt="{{ $full }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-xl font-black text-slate-400">
                            {{ $initials }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-[11px] font-semibold text-slate-500">
                @if($appliedAt)
                    Postulé le {{ \Illuminate\Support\Carbon::parse($appliedAt)->format('d/m/Y') }}
                @endif
            </div>
        </div>

        <div class="space-y-1">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">
                {{ $full }}
            </h3>

            <div class="flex items-center gap-1.5 text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-medium">{{ $email }}</span>
            </div>
        </div>

        <p class="mt-3 text-sm text-slate-500 leading-relaxed min-h-[3rem]">
            {{ $shortBio }}
        </p>

        <div class="mt-5 grid grid-cols-2 gap-3">
            <!-- détails candidat -->
            <a href="{{ $href }}"
               class="inline-flex justify-center items-center py-3 px-4 rounded-2xl border border-slate-200 bg-white text-slate-800 text-sm font-black hover:bg-slate-50">
                Détails
            </a>

            <!-- accepter candidature -->
            <form method="POST" action="{{ route('applications.accept', $applicationId) }}">
                @csrf
                @method('PATCH')

                <button type="submit"
                        {{ $disabledAccept ? 'disabled' : '' }}
                        class="w-full inline-flex justify-center items-center py-3 px-4 rounded-2xl text-sm font-black shadow-lg transition-all active:scale-95
                               {{ $disabledAccept ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-emerald-200' }}">
                    <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Accepter
                </button>
            </form>
        </div>
    </div>
</article>
