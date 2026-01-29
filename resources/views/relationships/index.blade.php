<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">Amis</h2>
                <p class="text-sm text-slate-500">Demandes d’amitié + liste d’amis (statique).</p>
            </div>
            <a href="{{ url('/search') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">
                Trouver des profils →
            </a>
        </div>
    </x-slot>

    @php
        // ---------- Données statiques ----------
        $received = [
            [
                'id' => 11,
                'name' => 'Youssef Amrani',
                'role' => 'RECHERCHEUR',
                'headline' => 'Spécialité • Frontend',
                'location' => 'Marrakech',
                'bio' => 'Je fais des interfaces propres et rapides avec Tailwind.',
                'tags' => ['Tailwind', 'Blade', 'UX'],
                'state' => 'pending_received',
            ],
        ];

        $sent = [
            [
                'id' => 12,
                'name' => 'TechNova SARL',
                'role' => 'RECRUTEUR',
                'headline' => 'Entreprise • SaaS RH',
                'location' => 'Casablanca',
                'bio' => 'Nous recrutons des profils backend/fullstack.',
                'tags' => ['Recrutement', 'SaaS', 'B2B'],
                'state' => 'pending_sent',
            ],
        ];

        $friends = [
            [
                'id' => 13,
                'name' => 'Imane El Fassi',
                'role' => 'RECHERCHEUR',
                'headline' => 'Développeuse Laravel',
                'location' => 'Rabat',
                'bio' => 'Passionnée par les APIs et les bonnes pratiques.',
                'tags' => ['Laravel', 'PHP', 'PostgreSQL'],
                'state' => 'friends',
            ],
            [
                'id' => 14,
                'name' => 'Atlas Hiring',
                'role' => 'RECRUTEUR',
                'headline' => 'Agence • IT',
                'location' => 'Casablanca',
                'bio' => 'Nous connectons des talents IT avec des équipes ambitieuses.',
                'tags' => ['IT', 'RH', 'Tech'],
                'state' => 'friends',
            ],
        ];
    @endphp

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Stats -->
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-sm text-slate-500">Demandes reçues</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-900">{{ count($received) }}</div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-sm text-slate-500">Demandes envoyées</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-900">{{ count($sent) }}</div>
                </div>
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <div class="text-sm text-slate-500">Amis</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-900">{{ count($friends) }}</div>
                </div>
            </div>

            <!-- Content -->
            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Received -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900">Demandes reçues</h3>
                        <span class="text-sm text-slate-500">{{ count($received) }}</span>
                    </div>

                    @forelse($received as $u)
                        <x-user-card
                            :href="url('/users/' . $u['id'])"
                            :name="$u['name']"
                            :role="$u['role']"
                            :headline="$u['headline']"
                            :location="$u['location']"
                            :bio="$u['bio']"
                            :tags="$u['tags']"
                            :state="$u['state']"
                        />
                    @empty
                        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 text-sm text-slate-500">
                            Aucune demande reçue.
                        </div>
                    @endforelse
                </div>

                <!-- Sent -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900">Demandes envoyées</h3>
                        <span class="text-sm text-slate-500">{{ count($sent) }}</span>
                    </div>

                    @forelse($sent as $u)
                        <x-user-card
                            :href="url('/users/' . $u['id'])"
                            :name="$u['name']"
                            :role="$u['role']"
                            :headline="$u['headline']"
                            :location="$u['location']"
                            :bio="$u['bio']"
                            :tags="$u['tags']"
                            :state="$u['state']"
                        />
                    @empty
                        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 text-sm text-slate-500">
                            Aucune demande envoyée.
                        </div>
                    @endforelse
                </div>

                <!-- Friends -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-slate-900">Mes amis</h3>
                        <span class="text-sm text-slate-500">{{ count($friends) }}</span>
                    </div>

                    @forelse($friends as $u)
                        <x-user-card
                            :href="url('/users/' . $u['id'])"
                            :name="$u['name']"
                            :role="$u['role']"
                            :headline="$u['headline']"
                            :location="$u['location']"
                            :bio="$u['bio']"
                            :tags="$u['tags']"
                            :state="$u['state']"
                        />
                    @empty
                        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 text-sm text-slate-500">
                            Aucun ami pour le moment.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
