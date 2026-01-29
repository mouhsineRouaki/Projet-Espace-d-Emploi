    @php
        $results = [
            [
                'id' => 1,
                'nom' => 'El Fassi',
                'prenom' => 'Imane',
                'role' => 'RECHERCHEUR',
                'email' => 'imane@example.com',
                'biographie' => 'Passionnée par Laravel, APIs, et qualité du code. Disponible pour opportunités backend.',
                'image' => 'https://i.pravatar.cc/200?img=32',
            ],
            [
                'id' => 2,
                'nom' => 'TechNova',
                'prenom' => 'SARL',
                'role' => 'RECRUTEUR',
                'email' => 'hr@technova.com',
                'biographie' => 'Entreprise SaaS RH. Recrutement backend/fullstack pour produits B2B.',
                'image' => 'https://i.pravatar.cc/200?img=12',
            ],
            [
                'id' => 3,
                'nom' => 'Amrani',
                'prenom' => 'Youssef',
                'role' => 'RECHERCHEUR',
                'email' => 'youssef@example.com',
                'biographie' => 'Frontend & intégration. UI propre, composants réutilisables, obsession de la finition.',
                'image' => 'https://i.pravatar.cc/200?img=48',
            ],
        ];
    @endphp

<x-app-layout>
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-50/50 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-emerald-50/50 blur-[100px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <span>Plateforme</span>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600">Exploration</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Trouver des <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-600">talents</span>
                </h2>
            </div>
            <a href="{{ url('/profile/manage') }}" 
               class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm hover:shadow-md transition-all">
                <span>Modifier mon profil</span>
                <svg class="ms-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    </x-slot>

    <div class="grid gap-8 lg:grid-cols-12">
        <aside class="lg:col-span-4 space-y-6">
            <div class="sticky top-6">
                <div class="relative overflow-hidden rounded-[2rem] bg-slate-900 p-6 text-white shadow-2xl shadow-indigo-200/50">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold">Astuces de pro 💡</h3>
                        <p class="mt-2 text-slate-400 text-sm leading-relaxed">
                            Optimisez votre recherche en utilisant des mots-clés spécifiques comme <span class="text-indigo-400 font-mono">"Laravel"</span> ou <span class="text-emerald-400 font-mono">"Design"</span>.
                        </p>
                        <div class="mt-6 pt-6 border-t border-white/10">
                            <h4 class="text-xs font-black uppercase tracking-widest text-slate-500 mb-3">Recherches populaires</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach(['imane', 'youssef', 'tech', 'backend'] as $tag)
                                    <a href="{{ url('/search?q='.$tag) }}" 
                                       class="px-3 py-1.5 rounded-lg bg-white/5 border border-white/10 text-xs font-medium hover:bg-white/10 transition-colors">
                                        #{{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-indigo-500/20 blur-3xl rounded-full"></div>
                </div>
            </div>
        </aside>

        <section class="lg:col-span-8 space-y-8">
            <div class="relative group">
                <form method="GET" action="{{ url('/search') }}">
                    <input
                        id="q" name="q" type="text"
                        placeholder="Qui recherchez-vous aujourd'hui ?"
                        class="w-full h-16 rounded-2xl border-none bg-white px-6 shadow-xl shadow-slate-200/50 text-lg placeholder:text-slate-400 focus:ring-2 focus:ring-indigo-500 transition-all group-hover:shadow-indigo-100"
                    />
                    <button class="absolute right-3 top-3 bottom-3 px-6 rounded-xl bg-slate-900 text-white font-bold text-sm hover:bg-indigo-600 transition-all active:scale-95">
                        Rechercher
                    </button>
                </form>
            </div>

            <div class="flex items-center justify-between px-2">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                    {{ count($results) }} profils trouvés
                </h3>
                <div class="h-px flex-1 mx-4 bg-slate-100"></div>
                <select class="bg-transparent border-none text-sm font-bold text-slate-600 focus:ring-0 cursor-pointer">
                    <option>Plus récents</option>
                    <option>Pertinence</option>
                </select>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                @foreach($results as $u)
                    <div class="transform transition-all duration-300 hover:z-10">
                        <x-user-card
                            :href="url('/users/' . $u['id'])"
                            :nom="$u['nom']"
                            :prenom="$u['prenom']"
                            :role="$u['role']"
                            :email="$u['email']"
                            :biographie="$u['biographie']"
                            :image="$u['image']"
                        />
                    </div>
                @endforeach
            </div>

            @if(count($results) == 0)
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Aucun résultat</h3>
                    <p class="text-slate-500 mt-1">Essayez avec un autre nom ou un mot-clé plus général.</p>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>