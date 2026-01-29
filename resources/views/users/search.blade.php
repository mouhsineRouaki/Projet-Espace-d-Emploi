<x-app-layout>
    <!-- Background glow -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-50/50 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-emerald-50/50 blur-[100px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <span>Plateforme</span>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600">Exploration</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Trouver des <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-600">talents</span>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Recherchez un utilisateur par <span class="font-semibold">nom</span> ou <span class="font-semibold">prénom</span>.
                </p>
            </div>

            <a href="{{ url('/profile/manage') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm hover:shadow-md transition-all">
                <span>Modifier mon profil</span>
                <svg class="ms-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </x-slot>

    <!-- SINGLE COLUMN (no aside) -->
    <section class="w-full space-y-6">        <!-- Search + meta container (same container as cards) -->
        <div class="rounded-[2rem] bg-white/80 backdrop-blur border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            <!-- Search bar -->
            <div class="p-5 sm:p-6 border-b border-slate-200/70">
                <form method="GET" action="{{ url('/search') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <div class="relative flex-1">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/>
                        </svg>

                        <!-- Height controlled: h-12 / sm:h-13 느낌 -->
                        <input
                            id="q" name="q" type="text" value="{{$q}}"
                            placeholder="Nom ou prénom…"
                            class="w-full h-12 sm:h-13 rounded-2xl border border-slate-200 bg-white pl-12 pr-4
                                   text-sm sm:text-base placeholder:text-slate-400
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                        />
                    </div>

                    <div class="flex gap-2">
                        <button
                            class="h-12 rounded-2xl bg-slate-900 px-5 text-white font-bold text-sm
                                   hover:bg-indigo-600 transition active:scale-[0.98]"
                        >
                            Rechercher
                        </button>

                        <a href="{{ url('/search') }}"
                           class="h-12 inline-flex items-center justify-center rounded-2xl border border-slate-200 px-5
                                  text-sm font-bold text-slate-700 hover:bg-slate-50">
                            Reset
                        </a>
                    </div>
                </form>

            <!-- Results header -->
            <div class="px-5 sm:px-6 py-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">
                        {{ count($users) }} profils trouvés
                    </h3>
                    <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-[11px] font-bold text-indigo-700 ring-1 ring-indigo-200">
                        Résultats
                    </span>
                </div>
            </div>

            <!-- Cards container -->
            <div class="px-5 sm:px-6 pb-6">
                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach($users as $u)
                        <div class="transform transition-all duration-300 hover:z-10">
                            <x-user-card
                                :href="route('users.show', $u->id)"
                                :userId="$u->id"
                                :nom="$u->nom"
                                :prenom="$u->prenom"
                                :role="$u->role"
                                :email="$u->email"
                                :biographie="$u->biographie"
                                :image="$u->image"
                            />
                        </div>
                    @endforeach
                </div>

                @if(count($users) == 0)
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Aucun résultat</h3>
                        <p class="text-slate-500 mt-1">Essayez un autre nom/prénom ou un mot-clé plus général.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
