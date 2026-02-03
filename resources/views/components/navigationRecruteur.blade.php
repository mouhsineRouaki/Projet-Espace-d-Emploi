<!-- {{-- resources/views/components/top-navbar.blade.php --}} -->
@props([
    'active' => 'dashboard', 
    'user'   => auth()->user(),
])

<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            {{-- Left side: logo + main nav --}}
            <div class="flex items-center space-x-8">
                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center">
                    <span
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 shadow-sm">
                        {{-- Tailwind-ish squiggle logo --}}
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M4 10.5C5.2 8 7 7 9 7c2.7 0 3.5 2 5.5 2 1.4 0 2.6-.7 3.5-2.1C17.8 12 16 13 14 13c-2.7 0-3.5-2-5.5-2-1.4 0-2.6.7-3.5 2.1Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </a>

                {{-- Main nav links --}}
                <div class="hidden md:flex items-center space-x-6 text-sm font-medium">
                    <a href="{{ route('dashboard.recruteur') }}"
                       class="pb-3 border-b-2 {{ $active === 'dashboard'
                            ? 'border-indigo-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
                        Dashboard Recruteur
                    </a>

                    <a href="{{route('profile.manage')}}"
                       class="pb-3 border-b-2 {{ $active === 'team'
                            ? 'border-indigo-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
                        Recherche
                    </a>

                    <a href="{{route('friends.index')}}"
                       class="pb-3 border-b-2 {{ $active === 'projects'
                            ? 'border-indigo-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
                        Amis
                    </a>

                    <a href=""
                       class="pb-3 border-b-2 {{ $active === 'calendar'
                            ? 'border-indigo-500 text-gray-900'
                            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
                        Notifications
                    </a>
                </div>
            </div>

            {{-- Right side: search + bell + avatar --}}
            <div class="flex items-center space-x-4">
                {{-- Search --}}
                <div class="hidden sm:block">
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                            </svg>
                        </span>
                        <input
                            type="text"
                            placeholder="Search"
                            class="block w-72 rounded-full border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm text-gray-700 placeholder-gray-400 shadow-inner focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50"
                        />
                    </div>
                </div>

                {{-- Bell --}}
                <button type="button"
                    class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <span class="sr-only">Notifications</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0" />
                    </svg>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">Déconnexion</span>
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                        </svg>
                    </button>
                </form>

                {{-- Avatar --}}
                <button
                    class="flex items-center rounded-full border-2 border-transparent focus:outline-none focus:border-indigo-500">
                    <img
                        class="h-9 w-9 rounded-full object-cover"
                        src="{{ $user?->image ?? 'https://i.pravatar.cc/150?img=3' }}"
                        alt="{{ $user?->name ?? 'User avatar' }}"
                    >
                </button>
            </div>
        </div>
    </div>
</nav>