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
                    <span class="text-indigo-600">Détails offre</span>
                </nav>

                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $offer->titre }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $offer->type_contrat }} @if($offer->ville) • {{ $offer->ville }} @endif
                </p>
            </div>
            

            <div class="flex items-center gap-2">
                <a href="{{ route('offers.accepted', $offer->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-black hover:bg-emerald-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Personnes acceptées
                </a>

                <a href="{{ route('offers.index') ?? url('/offers') }}"
                   class="inline-flex items-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-sm font-bold text-slate-700 shadow-sm hover:shadow-md transition-all">
                    <svg class="me-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Retour
                </a>
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

            <!-- Offer card -->
            <div class="rounded-[2rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="grid lg:grid-cols-3">
                    <div class="lg:col-span-1">
                        <div class="h-56 lg:h-full w-full bg-slate-100">
                            <img src="{{ $offer->image }}" alt="{{ $offer->titre }}"
                                 class="h-full w-full object-cover">
                        </div>
                    </div>

                    <div class="lg:col-span-2 p-6 sm:p-8 space-y-4">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-black text-slate-700">
                                {{ $offer->type_contrat }}
                            </span>

                            <span class="inline-flex items-center rounded-full bg-indigo-50 px-3 py-1 text-xs font-black text-indigo-700 ring-1 ring-indigo-200">
                                PUBLIÉE
                            </span>

                            <span class="text-xs text-slate-400 font-semibold">
                                • {{ $offer->created_at?->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="prose prose-slate max-w-none">
                            <p class="text-slate-700 leading-relaxed">
                                {{ $offer->description }}
                            </p>
                        </div>

                        <div class="pt-2 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="text-sm text-slate-500">
                                Recruteur :
                                <span class="font-bold text-slate-800">
                                    {{ $offer->recruiter?->prenom }} {{ $offer->recruiter?->nom }}
                                </span>
                            </div>

                            <div class="text-sm font-bold text-slate-700">
                                Candidatures :
                                <span class="text-slate-900">{{ $offer->applications->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applications list -->
            <div class="rounded-[2rem] bg-white border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-slate-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-black text-slate-900">Candidatures</h3>
                        <span class="text-sm font-bold text-slate-500">
                            {{ $offer->applications->count() }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">Liste des personnes qui ont postulé à cette offre.</p>
                </div>

                <div class="p-6 sm:p-8">
                    @if($offer->applications->count() === 0)
                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-6 text-slate-600">
                            Aucune candidature pour le moment.
                        </div>
                    @else
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($offer->applications as $app)
                                <x-applicant-card
                                    :applicationId="$app->id"
                                    :status="$app->status"
                                    :href="route('users.show', $app->rechercheur->user_id)"
                                    :userId="$app->rechercheur->user_id"
                                    :nom="$app->rechercheur->user->nom"
                                    :prenom="$app->rechercheur->user->prenom"
                                    :role="$app->rechercheur->user->role"
                                    :email="$app->rechercheur->user->email"
                                    :biographie="$app->rechercheur->user->biographie"
                                    :image="$app->rechercheur->user->image"
                                    :appliedAt="$app->created_at"
                                />
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
