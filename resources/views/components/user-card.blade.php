@props([
  'name' => 'Nom Prénom',
  'role' => 'CHERCHEUR',
  'specialite' => 'Développeur Laravel',
  'location' => 'Casablanca',
  'bio' => 'Bio courte de présentation (1-2 lignes).',
  'status' => 'neutral', // success|danger|neutral
])

@php
  $badge = match($status) {
    'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
    'danger'  => 'bg-rose-50 text-rose-700 ring-rose-200',
    default   => 'bg-slate-100 text-slate-700 ring-slate-200',
  };

  $roleLabel = $role === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur';
@endphp

<div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 hover:shadow-md transition">
    <div class="flex items-start justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-2xl bg-slate-200"></div>
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="font-semibold text-slate-900">{{ $name }}</h3>
                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $badge }}">
                        {{ $roleLabel }}
                    </span>
                </div>
                <p class="text-sm text-slate-600">{{ $specialite }} • {{ $location }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="#" class="rounded-xl border px-3 py-2 text-sm hover:bg-slate-50">Voir profil</a>
            <button class="rounded-xl bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700">
                Ajouter
            </button>
        </div>
    </div>

    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
        {{ $bio }}
    </p>

    <div class="mt-4 flex flex-wrap gap-2">
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-700">Nom</span>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-700">Spécialité</span>
        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-700">Profil</span>
    </div>
</div>
