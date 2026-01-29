<x-app-layout>
    <!-- Background glow -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full {{ $theme['glow'] }} blur-[120px]"></div>
        <div class="absolute top-[45%] -right-[5%] w-[30%] h-[30%] rounded-full bg-slate-100/60 blur-[110px]"></div>
    </div>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <span>Utilisateurs</span>
                    <span class="mx-2">/</span>
                    <span class="text-{{ $theme['main'] }}-600">Détails</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Profil <span class="text-transparent bg-clip-text bg-gradient-to-r {{ $theme['grad'] }}">{{ $role }}</span>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Informations essentielles du compte.
                </p>
            </div>

            <a href="{{ url('/search') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm hover:shadow-md transition-all">
                <svg class="me-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Retour</span>
            </a>
        </div>
    </x-slot>

    <section class="w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="group relative bg-white rounded-[2rem] border border-slate-100 overflow-hidden
                    shadow-[0_25px_70px_rgba(0,0,0,0.06)]">

                <!-- Glow -->
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    <div class="absolute -top-14 -left-14 w-40 h-40 {{ $theme['glow'] }} blur-3xl rounded-full"></div>
                </div>

                <!-- Cover -->
                <div class="relative h-44 w-full bg-gradient-to-br {{ $theme['grad'] }}">
                    <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                    </svg>

                    <div class="absolute top-5 right-5">
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/30">
                            {{ $role }}
                        </span>
                    </div>
                </div>

                <!-- Body -->
                <div class="relative px-6 pb-8">
                    <!-- Avatar -->
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

                        <!-- CTA -->
                        <a href="{{ url('/relationships') }}"
                           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl {{ $theme['btn'] }}
                                  text-white text-sm font-black shadow-lg transition-all active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                            Ajouter 
                        </a>
                    </div>

                    <!-- Name + Email + Created -->
                    <div class="space-y-2">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight group-hover:text-{{ $theme['main'] }}-600 transition-colors">
                            {{ $full }}
                        </h1>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6 text-slate-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-semibold">{{ $user->email }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3M5 11h14M7 21h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm font-semibold">Créé le {{ $created }}</span>
                            </div>
                        </div>

                        <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-black uppercase tracking-wider ring-1 {{ $theme['soft'] }}">
                            {{ $role }}
                        </span>
                    </div>

                    <!-- Bio -->
                    <div class="mt-6 rounded-3xl border border-slate-100 bg-slate-50 p-6">
                        <h3 class="text-xs font-black uppercase tracking-widest text-slate-400">Biographie</h3>
                        <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                            {{ $bio }}
                        </p>
                    </div>

                    <!-- Mobile CTA -->
                    <a href="{{ url('/relationships') }}"
                       class="mt-6 sm:hidden inline-flex w-full justify-center items-center gap-2 py-3 px-4 rounded-2xl {{ $theme['btn'] }}
                              text-white text-sm font-black shadow-lg transition-all active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 5v14M5 12h14" stroke-width="2.5" stroke-linecap="round"/>
                        </svg>
                        Ajouter
                    </a>
                </div>

                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-slate-50 rounded-full -z-10 group-hover:bg-{{ $theme['main'] }}-50 transition-colors"></div>
            </div>
        </div>
    </section>
</x-app-layout>
