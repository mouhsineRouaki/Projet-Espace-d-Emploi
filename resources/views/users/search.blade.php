<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Recherche</h2>
                <p class="text-sm text-slate-500">Trouver un utilisateur par <span class="font-semibold">nom</span> ou <span class="font-semibold">prénom</span>.</p>
            </div>

            <a href="{{ url('/profile/manage') }}" class="text-sm font-semibold text-[#0a66c2] hover:text-blue-700">
                Modifier mon profil →
            </a>
        </div>
    </x-slot>

    @php
        // Données statiques (remplace par DB plus tard)
        $results = [
            [
                'id' => 1,
                'nom' => 'El Fassi',
                'prenom' => 'Imane',
                'role' => 'RECHERCHEUR',
                'email' => 'imane@example.com',
                'biographie' => 'Passionnée par Laravel, les APIs, et la qualité du code. Disponible pour opportunités backend.',
                'image' => 'https://i.pravatar.cc/200?img=32',
                'state' => 'none',
            ],
            [
                'id' => 2,
                'nom' => 'TechNova',
                'prenom' => 'SARL',
                'role' => 'RECRUTEUR',
                'email' => 'hr@technova.com',
                'biographie' => 'Entreprise SaaS RH. Nous recrutons des profils backend et fullstack pour des produits B2B.',
                'image' => 'https://i.pravatar.cc/200?img=12',
                'state' => 'friends',
            ],
            [
                'id' => 3,
                'nom' => 'Amrani',
                'prenom' => 'Youssef',
                'role' => 'RECHERCHEUR',
                'email' => 'youssef@example.com',
                'biographie' => 'UI propre, composants réutilisables, et obsession de la qualité. Frontend & intégration.',
                'image' => 'https://i.pravatar.cc/200?img=48',
                'state' => 'pending_received',
            ],
        ];
    @endphp

    <div class="space-y-6">
        <!-- Search bar -->
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <form method="GET" action="{{ url('/search') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="flex-1">
                    <label class="sr-only" for="q">Recherche</label>
                    <div class="relative">
                        <input
                            id="q"
                            name="q"
                            type="text"
                            placeholder="Ex: imane, el fassi, youssef…"
                            class="w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-3 pr-12 text-sm placeholder:text-slate-500 focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                        />
                        <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                            <svg class="h-5 w-5 text-slate-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-slate-500">Tape un nom ou prénom, puis clique sur Rechercher.</p>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="rounded-xl bg-[#0a66c2] px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                        Rechercher
                    </button>
                    <a href="{{ url('/search') }}"
                       class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Results header -->
        <div class="flex items-center justify-between">
            <div class="text-sm text-slate-600">
                Résultats : <span class="font-semibold text-slate-900">{{ count($results) }}</span>
            </div>

            <div class="text-xs text-slate-500">
                Astuce: clique sur “Profil” pour voir les détails.
            </div>
        </div>

        <!-- Results grid -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($results as $u)
                <x-user-card
                    :href="url('/users/' . $u['id'])"
                    :nom="$u['nom']"
                    :prenom="$u['prenom']"
                    :role="$u['role']"
                    :email="$u['email']"
                    :biographie="$u['biographie']"
                    :image="$u['image']"
                    :state="$u['state']"
                />
            @endforeach
        </div>
    </div>
</x-app-layout>
