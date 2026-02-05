<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TalentBridge') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-[#f4f2ee] text-slate-900">
    <div class="min-h-screen">
        <x-navigation :active="$active ?? 'dashboard' " />

        @if (isset($header))
            <header class="py-5">
                <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl bg-white/80 backdrop-blur border border-slate-200/70 px-5 py-4 shadow-sm">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main class="pb-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <footer class="py-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
                © {{ date('Y') }} TalentBridge • Connecter recruteurs & chercheurs
            </div>
        </footer>
    </div>

    {{-- ✅ obligatoire pour Livewire --}}
    @livewireScripts
</body>
</html>
