@props([
    'active' => 'dashboard', 
    'user'   => auth()->user(),
])       
<div class="hidden md:flex items-center space-x-6 text-sm font-medium">
    <a href="{{ route('dashboard.rechercheur') }}"
       class="pb-3 border-b-2 {{ $active === 'dashboard'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Dashboard
    </a>
    <a href="{{ route('offers.rechercheurs.index') }}"
       class="pb-3 border-b-2 {{ $active === 'dashboard'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Offers
    </a>

    <a href="{{route('users.search')}}"
       class="pb-3 border-b-2 {{ $active === 'search'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Recherche
    </a>


    <a href="{{route('profile.manage')}}"
       class="pb-3 border-b-2 {{ $active === 'profile'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Profile
    </a>

    <a href="{{route('friends.index')}}"
       class="pb-3 border-b-2 {{ $active === 'amis'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Amis
    </a>

    <a href=""
       class="pb-3 border-b-2 {{ $active === 'notifications'
            ? 'border-indigo-500 text-gray-900'
            : 'border-transparent text-gray-500 hover:text-gray-900 hover:border-indigo-300' }}">
        Notifications
    </a>
</div>
</div>