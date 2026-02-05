<x-app-layout>
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-50/50 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-emerald-50/50 blur-[100px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-black text-slate-900">Offres</h2>
                <p class="text-sm text-slate-500">Explore et postule (style LinkedIn).</p>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:offers-rechercheurs />
        </div>
    </div>
</x-app-layout>
