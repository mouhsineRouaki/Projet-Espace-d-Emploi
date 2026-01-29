<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">Notifications</h2>
                <p class="text-sm text-slate-500">Historique des notifications (statique).</p>
            </div>
            <button class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Tout marquer comme lu
            </button>
        </div>
    </x-slot>

    @php
        // ---------- Données statiques ----------
        $notifications = [
            [
                'type' => 'friend_request',
                'title' => 'Nouvelle demande d’amitié',
                'text' => 'Youssef Amrani veut vous ajouter.',
                'time' => 'Il y a 5 min',
                'cta_primary' => 'Voir',
                'cta_secondary' => 'Ignorer',
            ],
            [
                'type' => 'accepted',
                'title' => 'Demande acceptée',
                'text' => 'TechNova SARL a accepté votre demande.',
                'time' => 'Il y a 2 h',
                'cta_primary' => 'Ouvrir profil',
                'cta_secondary' => null,
            ],
            [
                'type' => 'profile_view',
                'title' => 'Votre profil a été consulté',
                'text' => 'Atlas Hiring a consulté votre profil.',
                'time' => 'Hier',
                'cta_primary' => 'Voir détails',
                'cta_secondary' => null,
            ],
        ];

        $badgeClass = fn($type) => match($type) {
            'friend_request' => 'bg-blue-50 text-blue-700 ring-blue-200',
            'accepted' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'profile_view' => 'bg-slate-100 text-slate-700 ring-slate-200',
            default => 'bg-slate-100 text-slate-700 ring-slate-200',
        };

        $badgeLabel = fn($type) => match($type) {
            'friend_request' => 'Amitié',
            'accepted' => 'Acceptée',
            'profile_view' => 'Profil',
            default => 'Info',
        };
    @endphp

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @forelse($notifications as $n)
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="h-11 w-11 rounded-2xl bg-slate-200 shrink-0"></div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-slate-900">{{ $n['title'] }}</h3>
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $badgeClass($n['type']) }}">
                                        {{ $badgeLabel($n['type']) }}
                                    </span>
                                    <span class="text-xs text-slate-500">{{ $n['time'] }}</span>
                                </div>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $n['text'] }}
                                </p>
                            </div>
                        </div>

                        <div class="flex shrink-0 gap-2">
                            @if($n['cta_secondary'])
                                <button class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                    {{ $n['cta_secondary'] }}
                                </button>
                            @endif

                            @if($n['cta_primary'])
                                <button class="rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    {{ $n['cta_primary'] }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 text-sm text-slate-500">
                    Aucune notification.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
