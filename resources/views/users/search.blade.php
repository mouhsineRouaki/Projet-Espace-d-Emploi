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
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8 space-y-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Annuaire des Talents</h1>
                <p class="text-slate-500 mt-1">Connectez-vous avec les meilleurs profils de la plateforme.</p>
            </div>
        </div>

        <div class="relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-[#0a66c2] to-blue-400 rounded-2xl blur opacity-15 group-focus-within:opacity-25 transition duration-1000"></div>
            
            <form method="GET" action="{{ url('/search') }}" class="relative flex flex-col md:flex-row gap-3 bg-white p-3 rounded-2xl shadow-xl shadow-slate-200/50 ring-1 ring-slate-200">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input 
                        type="text" 
                        name="q" 
                        value="{{ request('q') }}"
                        placeholder="Rechercher un nom, un rôle, une compétence..." 
                        class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-xl text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-[#0a66c2] transition"
                    >
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-8 py-4 bg-[#0a66c2] hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-200">
                        Trouver
                    </button>
                    <a href="{{ url('/search') }}" class="px-4 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </a>
                </div>
            </form>
        </div>

        <div class="space-y-6">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400">Résultats ({{ count($results) }})</h2>
                <div class="h-px flex-1 bg-slate-100 mx-4"></div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($results as $u)
                    <x-user-card :user="$u" />
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>