<nav x-data="{ open: false }" class="bg-white border-b border-slate-100">
    @php
        $user = Auth::user();
        $fullName = trim(($user->nom ?? $user->name ?? 'Utilisateur') . ' ' . ($user->prenom ?? ''));
        $role = $user->role ?? null; // 'RECRUTEUR' | 'RECHERCHEUR'
        $roleLabel = $role === 'RECRUTEUR' ? 'Recruteur' : ($role === 'RECHERCHEUR' ? 'Chercheur' : 'Compte');

        // Statique (plus tard tu le remplaces par tes vraies données)
        $notifCount = 3;
        $requestsCount = 1;
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left -->
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-2xl bg-slate-900"></div>
                    <div class="leading-tight">
                        <div class="font-semibold text-slate-900">TalentBridge</div>
                        <div class="text-xs text-slate-500">Recruteurs • Chercheurs</div>
                    </div>
                </a>

                <!-- Links desktop -->
                <div class="hidden sm:flex items-center gap-1">
                    <x-nav-link :href="url('/dashboard')" :active="request()->is('dashboard')">
                        Dashboard
                    </x-nav-link>

                    <x-nav-link :href="url('/search')" :active="request()->is('search')">
                        Recherche
                    </x-nav-link>

                    <x-nav-link :href="url('/relationships')" :active="request()->is('relationships')">
                        Amis
                        @if($requestsCount > 0)
                            <span class="ml-2 inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">
                                {{ $requestsCount }}
                            </span>
                        @endif
                    </x-nav-link>

                    <x-nav-link :href="url('/notifications')" :active="request()->is('notifications')">
                        Notifications
                        @if($notifCount > 0)
                            <span class="ml-2 inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <!-- Center: Search (desktop) -->
            <div class="hidden lg:flex items-center w-[420px]">
                <form method="GET" action="{{ url('/search') }}" class="w-full">
                    <label class="sr-only" for="q">Recherche</label>
                    <div class="relative">
                        <input
                            id="q"
                            name="q"
                            type="text"
                            placeholder="Nom, spécialité, entreprise…"
                            class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 pr-10 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:ring-blue-500"
                        />
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                            <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21 21l-4.3-4.3m1.8-5.2a7 7 0 11-14 0 7 7 0 0114 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- Bell icon -->
                <a href="{{ url('/notifications') }}"
                   class="relative inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-slate-200 bg-white hover:bg-slate-50">
                    <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M9 17a3 3 0 006 0" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    @if($notifCount > 0)
                        <span class="absolute -top-1 -right-1 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-blue-600 px-1 text-xs font-semibold text-white">
                            {{ $notifCount }}
                        </span>
                    @endif
                </a>

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50">
                            <div class="h-9 w-9 rounded-2xl bg-slate-200"></div>
                            <div class="text-left leading-tight">
                                <div class="font-semibold text-slate-900">{{ $fullName }}</div>
                                <div class="text-xs text-slate-500">{{ $roleLabel }}</div>
                            </div>
                            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.24 4.5a.75.75 0 01-1.08 0l-4.24-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="url('/profile/manage')">
                            Gestion du profil
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            Profil (Breeze)
                        </x-dropdown-link>

                        <div class="my-1 border-t border-slate-100"></div>

                        <!-- Logout (Breeze) -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center rounded-2xl p-2 text-slate-500 hover:bg-slate-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100">
        <div class="p-4">
            <form method="GET" action="{{ url('/search') }}">
                <input name="q" type="text" placeholder="Nom, spécialité, entreprise…"
                       class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"/>
            </form>
        </div>

        <div class="px-4 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/dashboard')" :active="request()->is('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/search')" :active="request()->is('search')">
                Recherche
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/relationships')" :active="request()->is('relationships')">
                Amis
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="url('/notifications')" :active="request()->is('notifications')">
                Notifications
            </x-responsive-nav-link>

            <div class="mt-3 border-t border-slate-100 pt-3">
                <x-responsive-nav-link :href="url('/profile/manage')">
                    Gestion du profil
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil (Breeze)
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Déconnexion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
