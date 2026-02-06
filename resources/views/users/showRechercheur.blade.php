<x-app-layout>
    @php
        $r = $rechercheur;
        $user = $r->user;

        $theme = [
            'main' => 'emerald',
            'grad' => 'from-teal-500 to-emerald-500',
            'soft' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'glow' => 'bg-emerald-400/20',
            'btn'  => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200',
        ];

        $full = trim(($user->prenom ?? '').' '.($user->nom ?? ($user->name ?? 'Utilisateur')));
        $initials = mb_strtoupper(mb_substr($user->prenom ?: 'U', 0, 1) . mb_substr($user->nom ?: 'U', 0, 1));
        $created = optional($user->created_at)->format('d/m/Y');
        $bio = $user->biographie ?: 'Aucune biographie pour le moment.';

        $isMe = auth()->check() && auth()->id() === $user->id;
    @endphp

    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full {{ $theme['glow'] }} blur-[120px]"></div>
        <div class="absolute top-[45%] -right-[5%] w-[30%] h-[30%] rounded-full bg-slate-100/60 blur-[110px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <span>Rechercheurs</span>
                    <span class="mx-2">/</span>
                    <span class="text-{{ $theme['main'] }}-600">Détails</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Profil <span class="text-transparent bg-clip-text bg-gradient-to-r {{ $theme['grad'] }}">Chercheur</span>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    CV complet : profil, formations, expériences et compétences.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('users.search') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm hover:shadow-md transition-all">
                    <svg class="me-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Retour
                </a>

                @if($isMe)
                    <a href="{{ route('rechercheur.profile.edit') }}"
                       class="inline-flex items-center px-4 py-2 rounded-xl {{ $theme['btn'] }} text-white text-sm font-black shadow-lg transition-all active:scale-95">
                        Modifier mon profil
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER CARD -->
            <div class="group relative bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-[0_25px_70px_rgba(0,0,0,0.06)]">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <div class="absolute -top-14 -left-14 w-40 h-40 {{ $theme['glow'] }} blur-3xl rounded-full"></div>
                </div>

                <div class="relative h-44 w-full bg-gradient-to-br {{ $theme['grad'] }}">
                    <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                    </svg>

                    <div class="absolute top-5 right-5 flex items-center gap-2">
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/30">
                            Chercheur
                        </span>
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/30">
                            {{ $r->specialite ?? 'Spécialité' }}
                        </span>
                    </div>
                </div>

                <div class="relative px-6 pb-8">
                    <div class="relative -mt-16 mb-4 flex items-end justify-between gap-4">
                        <div class="relative inline-block">
                            <div class="h-28 w-28 rounded-3xl bg-white p-2 shadow-2xl transition-transform duration-500 group-hover:rotate-2">
                                <div class="h-full w-full rounded-2xl overflow-hidden bg-slate-100 border border-slate-50">
                                    @if($user->image)
                                        <img src="{{ $user->image }}" alt="{{ $full }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-3xl font-black text-slate-400">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="absolute bottom-2 right-2 h-6 w-6 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                        </div>

                        @if(!empty($r->cv_path))
                            <a href="{{ $r->cv_path }}" target="_blank"
                               class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-900 text-white text-sm font-black shadow-lg transition-all active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 7h10M7 11h10M7 15h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                </svg>
                                Ouvrir CV
                            </a>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight group-hover:text-{{ $theme['main'] }}-600 transition-colors">
                            {{ $full }}
                        </h1>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-semibold">{{ $user->email }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3M5 11h14M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-semibold">Créé le {{ $created }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 pt-2">
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-wider ring-1 {{ $theme['soft'] }}">
                                {{ $r->titre_profil ?? 'Titre du profil' }}
                            </span>
                            @if(!empty($r->ville))
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-wider ring-1 bg-slate-50 text-slate-700 ring-slate-200">
                                    {{ $r->ville }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Biographie</h3>
                        <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                            {{ $bio }}
                        </p>
                    </div>

                    @if(!empty($r->cv_path))
                        <a href="{{ $r->cv_path }}" target="_blank"
                           class="mt-6 sm:hidden inline-flex w-full justify-center items-center gap-2 py-3 px-4 rounded-2xl bg-slate-900 text-white text-sm font-black shadow-lg transition-all active:scale-95">
                            Ouvrir CV
                        </a>
                    @endif
                </div>

                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-slate-50 rounded-full -z-10 group-hover:bg-{{ $theme['main'] }}-50 transition-colors"></div>
            </div>

            <!-- GRID SECTIONS -->
            <div class="grid gap-6 lg:grid-cols-3">

                <!-- FORMATIONS -->
                <div class="rounded-[2rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-black text-slate-900">Formations</h3>
                            <span class="text-sm font-bold text-slate-500">{{ $r->formations->count() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Diplômes, écoles, années.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($r->formations as $f)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="font-black text-slate-900">{{ $f->diplome }}</div>
                                <div class="text-sm font-semibold text-slate-600">{{ $f->ecole }}</div>
                                <div class="text-xs text-slate-500 mt-1">
                                    {{ $f->annee_obtention ? 'Année: '.$f->annee_obtention : 'Année: —' }}
                                </div>
                                @if($f->description)
                                    <p class="mt-2 text-sm text-slate-600">{{ $f->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                Aucune formation ajoutée.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- EXPERIENCES -->
                <div class="rounded-[2rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-black text-slate-900">Expériences</h3>
                            <span class="text-sm font-bold text-slate-500">{{ $r->experiences->count() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Postes, entreprises, durées.</p>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse($r->experiences as $e)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <div class="font-black text-slate-900">{{ $e->poste }}</div>
                                <div class="text-sm font-semibold text-slate-600">{{ $e->entreprise }}</div>

                                <div class="text-xs text-slate-500 mt-1">
                                    @php
                                        $debut = $e->date_debut ? \Carbon\Carbon::parse($e->date_debut)->format('m/Y') : '—';
                                        $fin = $e->en_poste ? 'Présent' : ($e->date_fin ? \Carbon\Carbon::parse($e->date_fin)->format('m/Y') : '—');
                                    @endphp
                                    {{ $debut }} → {{ $fin }}
                                </div>

                                @if($e->description)
                                    <p class="mt-2 text-sm text-slate-600">{{ $e->description }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                Aucune expérience ajoutée.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- SKILLS -->
                <div class="rounded-[2rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                    <div class="p-6 border-b border-slate-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-black text-slate-900">Compétences</h3>
                            <span class="text-sm font-bold text-slate-500">{{ $r->skills->count() }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">Skills + niveau.</p>
                    </div>

                    <div class="p-6">
                        @if($r->skills->count() === 0)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                                Aucune compétence ajoutée.
                            </div>
                        @else
                            <div class="flex flex-wrap gap-2">
                                @foreach($r->skills as $s)
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-2 text-xs font-black bg-slate-100 text-slate-800">
                                        {{ $s->nom }}
                                        @if(!empty($s->pivot?->niveau))
                                            <span class="rounded-full px-2 py-0.5 text-[10px] font-black {{ $theme['soft'] }}">
                                                {{ $s->pivot->niveau }}
                                            </span>
                                        @endif
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </section>
</x-app-layout>
