@props([
    'href' => '#',
    'nom' => 'Nom',
    'prenom' => 'Prénom',
    'role' => 'RECHERCHEUR', 
    'email' => 'email@exemple.com',
    'biographie' => 'Bio…',
    'image' => null,
])

@php
    $full = trim($prenom.' '.$nom);
    $roleLabel = $role === 'RECRUTEUR' ? 'Recruteur' : 'Chercheur';

    // Configuration des thèmes (Couleurs cohérentes)
    $theme = $role === 'RECRUTEUR' 
        ? [
            'main' => 'indigo',
            'grad' => 'from-violet-600 to-indigo-600',
            'soft' => 'bg-violet-50 text-violet-700 ring-violet-200',
            'glow' => 'bg-violet-400/20',
            'btn'  => 'bg-violet-600 hover:bg-violet-700 shadow-violet-200'
          ]
        : [
            'main' => 'emerald',
            'grad' => 'from-teal-500 to-emerald-500',
            'soft' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'glow' => 'bg-emerald-400/20',
            'btn'  => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-200'
          ];

    $initials = mb_strtoupper(mb_substr($prenom, 0, 1) . mb_substr($nom, 0, 1));
    $shortBio = \Illuminate\Support\Str::limit($biographie ?? 'Aucune biographie disponible pour le moment.', 100);
@endphp

<article class="group relative max-w-sm w-full bg-white rounded-[2rem] border border-slate-100 p-3 transition-all duration-500 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] hover:-translate-y-2">
    
    <div class="absolute inset-0 transition-opacity opacity-0 group-hover:opacity-100 duration-500">
        <div class="absolute -top-10 -left-10 w-32 h-32 {{ $theme['glow'] }} blur-3xl rounded-full"></div>
    </div>

    <div class="relative h-32 w-full rounded-[1.5rem] overflow-hidden bg-gradient-to-br {{ $theme['grad'] }}">
        <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
        </svg>
        
        <div class="absolute top-3 right-3">
            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white rounded-full border border-white/30">
                {{ $roleLabel }}
            </span>
        </div>
    </div>

    <div class="relative px-4 pb-4">
        <div class="relative -mt-12 mb-3">
            <div class="relative inline-block">
                <div class="h-24 w-24 rounded-3xl bg-white p-1.5 shadow-xl transition-transform duration-500 group-hover:rotate-3">
                    <div class="h-full w-full rounded-2xl overflow-hidden bg-slate-100 border border-slate-50">
                        @if($image)
                            <img src="{{ $image }}" alt="{{ $full }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-2xl font-black text-slate-400">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="absolute bottom-1 right-1 h-5 w-5 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
            </div>
        </div>

        <div class="space-y-1">
            <h3 class="text-xl font-black text-slate-800 tracking-tight group-hover:text-{{ $theme['main'] }}-600 transition-colors">
                {{ $full }}
            </h3>
            <div class="flex items-center gap-1.5 text-slate-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <span class="text-xs font-medium">{{ $email }}</span>
            </div>
        </div>

        <p class="mt-4 text-sm text-slate-500 leading-relaxed min-h-[3rem]">
            {{ $shortBio }}
        </p>

        <div class="mt-6 flex items-center gap-3">
            <a href="{{ $href }}" 
               class="flex-1 inline-flex justify-center items-center py-3 px-4 rounded-2xl {{ $theme['btn'] }} text-white text-sm font-bold shadow-lg transition-all active:scale-95">
                Voir Profil
            </a>
            <button class="p-3 rounded-2xl border border-slate-200 text-slate-400 hover:text-{{ $theme['main'] }}-600 hover:border-{{ $theme['main'] }}-200 hover:bg-{{ $theme['main'] }}-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </button>
        </div>
    </div>

    <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-slate-50 rounded-full -z-10 group-hover:bg-{{ $theme['main'] }}-50 transition-colors"></div>
</article>