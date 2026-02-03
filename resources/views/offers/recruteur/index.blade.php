<x-app-layout>
    <!-- Background glow -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-50/50 blur-[120px]"></div>
        <div class="absolute top-[40%] -right-[5%] w-[30%] h-[30%] rounded-full bg-emerald-50/50 blur-[100px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="flex mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">
                    <span>Recruteur</span>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600">Offres</span>
                </nav>

                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Mes <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-600">offres</span>
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Créez et gérez vos offres d’emploi.
                </p>
            </div>


            <div x-data="{ open:false }" class="flex items-center gap-2">
                <button @click="open = true"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-black hover:bg-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v14M5 12h14"/>
                    </svg>
                    Créer une offre
                </button>

                <template x-teleport="body">
                    <div
                        x-cloak
                        x-show="open"
                        x-transition.opacity
                        @keydown.escape.window="open = false"
                        class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                    >
                        <!-- overlay -->
                        <div class="absolute inset-0 bg-slate-900/60" @click="open=false"></div>

                        <!-- panel -->
                        <div
                            @click.stop
                            x-transition
                            class="relative z-10 w-full max-w-2xl rounded-[2rem] bg-white shadow-2xl border border-slate-200 overflow-hidden"
                        >
                            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-black text-slate-900">Nouvelle offre</h3>
                                    <p class="text-sm text-slate-500">Remplis les champs obligatoires (*)</p>
                                </div>
                                <button @click="open=false" class="p-2 rounded-xl hover:bg-slate-100 text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>

                            <form method="POST" action="{{ route('offers.store') }}" class="p-6 space-y-4">
                                @csrf

                                @if ($errors->any())
                                    <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                        <ul class="list-disc ms-5">
                                            @foreach ($errors->all() as $e)
                                                <li>{{ $e }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-sm font-bold text-slate-700">Type contrat *</label>
                                        <select name="type_contrat"
                                                class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="CDI">CDI</option>
                                            <option value="CDD">CDD</option>
                                            <option value="Full-time">Full-time</option>
                                            <option value="Stage">Stage</option>
                                            <option value="Freelance">Freelance</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="text-sm font-bold text-slate-700">Ville</label>
                                        <input name="ville" type="text" placeholder="Casablanca, Rabat…"
                                               class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-slate-700">Titre *</label>
                                        <input name="titre" type="text" placeholder="Ex: Développeur Fullstack"
                                               class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-slate-700">Description *</label>
                                        <textarea name="description" rows="5" placeholder="Détail du poste..."
                                                  class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                    </div>

                                    <div class="sm:col-span-2">
                                        <label class="text-sm font-bold text-slate-700">Image (URL) *</label>
                                        <input name="image" type="url" placeholder="https://..."
                                               class="mt-1 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"/>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-2 pt-2">
                                    <button type="button" @click="open=false"
                                            class="rounded-2xl border border-slate-200 px-5 py-2.5 text-sm font-black text-slate-700 hover:bg-slate-50">
                                        Annuler
                                    </button>
                                    <button type="submit"
                                            class="rounded-2xl bg-indigo-600 px-5 py-2.5 text-sm font-black text-white hover:bg-indigo-700">
                                        Créer
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cards -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($offers as $offer)
                    <x-job-offer-card :offer="$offer" />
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-2xl bg-white p-10 text-center ring-1 ring-slate-200">
                        <h3 class="text-lg font-black text-slate-900">Aucune offre</h3>
                        <p class="mt-1 text-slate-500">Clique sur “Créer une offre”.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
