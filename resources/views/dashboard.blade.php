<x-app-layout>
    <x-slot name="header">
        @php
            $u = Auth::user();
            $nom = $u->nom ?? '';
            $prenom = $u->prenom ?? '';
            $full = trim(($prenom ?: '') . ' ' . ($nom ?: ($u->name ?? 'Utilisateur')));
        @endphp

        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Dashboard</h2>
                <p class="text-sm text-slate-500">
                    Bienvenue, <span class="font-semibold text-slate-900">{{ $full }}</span>.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ url('/search') }}"
                   class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    Rechercher des talents
                </a>
                <a href="{{ url('/profile/manage') }}"
                   class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Gérer mon profil
                </a>
            </div>
        </div>
    </x-slot>

    @php
        // stats statiques (tu brancheras DB plus tard)
        $stats = [
            ['label' => 'Profils consultés', 'value' => 12],
            ['label' => 'Demandes d’amitié', 'value' => 3],
            ['label' => 'Notifications', 'value' => 5],
            ['label' => 'Suggestions', 'value' => 8],
        ];

        $quickActions = [
            [
                'title' => 'Recherche',
                'desc' => 'Trouver un utilisateur par nom/prénom.',
                'href' => url('/search'),
                'btn' => 'Ouvrir',
            ],
            [
                'title' => 'Réseau (Amis)',
                'desc' => 'Gérer les demandes et la liste d’amis.',
                'href' => url('/relationships'),
                'btn' => 'Voir le réseau',
            ],
            [
                'title' => 'Notifications',
                'desc' => 'Voir les dernières activités et demandes.',
                'href' => url('/notifications'),
                'btn' => 'Voir',
            ],
            [
                'title' => 'Profil',
                'desc' => 'Modifier bio, photo (URL), nom/prénom.',
                'href' => url('/profile/manage'),
                'btn' => 'Modifier',
            ],
        ];

        $suggestions = [
            [
                'id' => 1,
                'nom' => 'El Fassi',
                'prenom' => 'Imane',
                'role' => 'RECHERCHEUR',
                'email' => 'imane@example.com',
                'biographie' => 'Laravel backend, APIs, PostgreSQL. Disponible.',
                'image' => 'https://i.pravatar.cc/200?img=32',
            ],
            [
                'id' => 2,
                'nom' => 'TechNova',
                'prenom' => 'SARL',
                'role' => 'RECRUTEUR',
                'email' => 'hr@technova.com',
                'biographie' => 'Entreprise SaaS RH. Recrute fullstack.',
                'image' => 'https://i.pravatar.cc/200?img=12',
            ],
        ];
    @endphp

    <div class="space-y-6">
        <!-- Stats -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $s)
                <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                    <div class="text-xs text-slate-500">{{ $s['label'] }}</div>
                    <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $s['value'] }}</div>
                    <div class="mt-3 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full w-2/3 rounded-full bg-indigo-600/70"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Quick actions -->
        <div class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Actions rapides</h3>
                        <p class="mt-1 text-sm text-slate-500">Accède vite aux pages principales.</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-50 grid place-items-center">
                        <svg class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 6v12M6 12h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach($quickActions as $a)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 hover:bg-white transition">
                            <div class="font-semibold text-slate-900">{{ $a['title'] }}</div>
                            <div class="mt-1 text-sm text-slate-600">{{ $a['desc'] }}</div>
                            <a href="{{ $a['href'] }}"
                               class="mt-4 inline-flex rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                                {{ $a['btn'] }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Profile card -->
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-base font-semibold text-slate-900">Mon compte</h3>
                        <p class="mt-1 text-sm text-slate-500">Infos de l’utilisateur connecté.</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-slate-100 grid place-items-center">
                        <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M16 11a4 4 0 10-8 0 4 4 0 008 0z" stroke="currentColor" stroke-width="2"/>
                            <path d="M20 20a8 8 0 10-16 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center gap-4">
                        <img src="{{$u?->image}}" class="h-14 w-14 rounded-2xl bg-slate-200 grid place-items-center font-bold text-slate-700"/>
                        <div class="min-w-0">
                            <div class="font-semibold text-slate-900 truncate">{{ $full }}</div>
                            <div class="text-sm text-slate-600 truncate">{{ $u->email }}</div>
                            <div class="mt-2 inline-flex rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-200">
                                {{ $u->role ?? 'RECHERCHEUR' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ url('/profile/manage') }}"
                           class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Modifier profil
                        </a>
                        <a href="{{ url('/notifications') }}"
                           class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Voir notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Suggestions -->
        <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-semibold text-slate-900">Suggestions</h3>
                    <p class="mt-1 text-sm text-slate-500">Profils recommandés (statique).</p>
                </div>
                <a href="{{ url('/search') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                    Voir plus →
                </a>
            </div>

            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                @foreach($suggestions as $s)
                    <x-user-card
                        :href="url('/users/' . $s['id'])"
                        :nom="$s['nom']"
                        :prenom="$s['prenom']"
                        :role="$s['role']"
                        :email="$s['email']"
                        :biographie="$s['biographie']"
                        :image="$s['image']"
                    />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
