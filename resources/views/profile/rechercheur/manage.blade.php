<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Gestion du profil</h2>
                <p class="text-sm text-slate-500">Modifier et enregistrer vos informations.</p>
            </div>
        </div>
    </x-slot>

    @php
        $u = $u ?? Auth::user();

        // ✅ role (enum ou string)
        $roleValue = is_object($u->role)
            ? ($u->role->value ?? $u->role->name ?? 'RECHERCHEUR')
            : ($u->role ?? 'RECHERCHEUR');

        $roleValue = strtoupper((string)$roleValue);

        // ✅ relation "rechercheur" : $u->rechercheur (à créer côté Model)
        $r = $u->rechercheur ?? null;

        $isChercheur = $roleValue === 'RECHERCHEUR';
    @endphp

    @if(session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            <ul class="list-disc ms-5 space-y-1">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.manage.update') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @method('PATCH')

        <!-- Left -->
        <aside class="space-y-4">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <img
                        src="{{ $u->image ?? 'https://i.pravatar.cc/150?img=3' }}"
                        class="h-12 w-12 rounded-2xl bg-slate-200 object-cover"
                        alt="Photo profil"
                    />
                    <div class="min-w-0">
                        <div class="font-semibold truncate">
                            {{ trim(($u->prenom ?? '').' '.($u->nom ?? 'Utilisateur')) }}
                        </div>
                        <div class="text-xs text-slate-500 truncate">{{ $u->email ?? '' }}</div>
                    </div>
                </div>

                <div class="mt-4 grid gap-2">
                    <button type="submit"
                            class="rounded-xl bg-[#0a66c2] px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Enregistrer
                    </button>

                    <a href="{{ url('/dashboard') }}"
                       class="text-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Annuler
                    </a>
                </div>
            </div>

            <!-- Quick tips -->
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-slate-900">Conseils</h3>
                <p class="mt-1 text-sm text-slate-600 leading-relaxed">
                    Un bon titre + une spécialité claire rendent votre profil beaucoup plus visible dans la recherche.
                </p>

                @if($isChercheur)
                    <div class="mt-3 rounded-xl bg-indigo-50 border border-indigo-200 px-3 py-2 text-xs font-semibold text-indigo-800">
                        Profil Chercheur : complétez “Titre du profil” et “Spécialité”.
                    </div>
                @endif
            </div>
        </aside>

        <!-- Form -->
        <section class="lg:col-span-2">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-6">

                <!-- Bloc 1: infos générales -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-slate-900">Informations générales</h3>
                        <span class="text-xs font-bold text-slate-500">
                            {{ $roleValue === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur' }}
                        </span>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Nom</label>
                            <input
                                name="nom"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                value="{{ old('nom', $u->nom ?? '') }}"
                            >
                            @error('nom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Prénom</label>
                            <input
                                name="prenom"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                value="{{ old('prenom', $u->prenom ?? '') }}"
                            >
                            @error('prenom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">Biographie</label>
                            <textarea
                                name="biographie"
                                rows="4"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                            >{{ old('biographie', $u->biographie ?? '') }}</textarea>
                            @error('biographie') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Image (url)</label>
                            <input
                                name="image"
                                placeholder="https://..."
                                value="{{ old('image', $u->image ?? '') }}"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                            >
                            @error('image') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-slate-700">Rôle</label>
                            <select
                                name="role"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                            >
                                <option value="RECHERCHEUR" @selected(old('role', $roleValue) === 'RECHERCHEUR')>Chercheur</option>
                                <option value="RECRUTEUR" @selected(old('role', $roleValue) === 'RECRUTEUR')>Recruteur</option>
                            </select>
                            @error('role') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Bloc 2: Infos chercheur -->
                @if($isChercheur)
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">Profil Chercheur (CV)</h3>
                                <p class="mt-1 text-sm text-slate-600">
                                    Ces champs viennent de la table <span class="font-bold">rechercheurs</span>.
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 ring-1 ring-indigo-200">
                                Chercheur
                            </span>
                        </div>

                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label class="text-sm font-semibold text-slate-700">Titre du profil</label>
                                <input
                                    name="titre_profil"
                                    placeholder="Ex: Développeur Fullstack"
                                    value="{{ old('titre_profil', $r->titre_profil ?? '') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                @error('titre_profil') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Spécialité</label>
                                <input
                                    name="specialite"
                                    placeholder="Ex: Laravel, UI/UX, Data..."
                                    value="{{ old('specialite', $r->specialite ?? '') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                @error('specialite') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Ville</label>
                                <input
                                    name="ville"
                                    placeholder="Casablanca, Rabat..."
                                    value="{{ old('ville', $r->ville ?? '') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                @error('ville') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-sm font-semibold text-slate-700">CV (URL ou path)</label>
                                <input
                                    name="cv_path"
                                    placeholder="Ex: storage/cv/mouhsine.pdf ou https://..."
                                    value="{{ old('cv_path', $r->cv_path ?? '') }}"
                                    class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                @error('cv_path') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror

                                @if(!empty($r?->cv_path))
                                    <div class="mt-3 flex items-center justify-between gap-2 rounded-xl bg-white border border-slate-200 px-4 py-3">
                                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                            </svg>
                                            CV enregistré
                                        </div>
                                        <a href="{{ $r->cv_path }}" target="_blank"
                                           class="inline-flex items-center rounded-lg bg-slate-900 px-3 py-2 text-xs font-bold text-white hover:bg-slate-800">
                                            Ouvrir
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Sécurité -->
                <div class="rounded-2xl bg-slate-50 border border-slate-200/70 p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Sécurité</h3>
                    <p class="mt-1 text-sm text-slate-600">
                        Changement de mot de passe : utilise la page Breeze.
                    </p>
                    <a href="{{ route('profile.edit') }}"
                       class="mt-3 inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                        Ouvrir sécurité
                    </a>
                </div>

            </div>
        </section>
    </form>
</x-app-layout>
