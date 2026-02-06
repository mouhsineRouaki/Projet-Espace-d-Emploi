<x-app-layout>
    {{-- Background soft --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute -top-[18%] -left-[10%] w-[42%] h-[42%] rounded-full bg-indigo-50/60 blur-[120px]"></div>
        <div class="absolute top-[35%] -right-[8%] w-[38%] h-[38%] rounded-full bg-emerald-50/60 blur-[120px]"></div>
    </div>

    <x-slot name="header">
        <div class="flex items-end justify-between gap-3">
            <div>
                <nav class="flex mb-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                    <span>Compte</span>
                    <span class="mx-2">/</span>
                    <span class="text-indigo-600">Profil</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Gestion du <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-600">profil</span>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Modifiez vos informations et enregistrez les changements.
                </p>
            </div>
        </div>
    </x-slot>

    @php $u = $u ?? Auth::user(); @endphp

    @if(session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.manage.update') }}">
        @csrf
        @method('PATCH')

        {{-- Top Profile Card --}}
        <div class="rounded-[2rem] bg-white/80 backdrop-blur border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden">
            {{-- Cover --}}
            <div class="relative h-36 bg-gradient-to-r from-indigo-600 via-violet-600 to-emerald-500">
                <svg class="absolute inset-0 w-full h-full opacity-20" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
                <div class="absolute bottom-3 left-6 text-white/90 text-xs font-black uppercase tracking-widest">
                    Profil & paramètres
                </div>
            </div>

            {{-- Avatar + Identity --}}
            <div class="px-6 pb-6 pt-10">
                <div class="-mt-10 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                    <div class="flex items-end gap-4">
                        <div class="h-20 w-20 rounded-3xl bg-white p-1.5 shadow-2xl">
                            <img
                                src="{{ $u->image ?? 'https://i.pravatar.cc/150?img=3' }}"
                                class="h-full w-full rounded-2xl object-cover bg-slate-200"
                                alt="Photo profil"
                            />
                        </div>

                        <div class="min-w-0 pb-1">
                            <div class="text-lg font-black text-slate-900 truncate">
                                {{ trim(($u->prenom ?? '').' '.($u->nom ?? 'Utilisateur')) }}
                            </div>
                            <div class="text-sm text-slate-500 truncate">{{ $u->email ?? '' }}</div>
                        </div>
                    </div>

                    {{-- Quick actions (desktop) --}}
                    <div class="hidden sm:flex items-center gap-2">
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-50">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-[#0a66c2] px-5 py-2.5 text-sm font-black text-white hover:bg-blue-700">
                            Enregistrer
                        </button>
                    </div>
                </div>

                {{-- Form content --}}
                <div class="mt-6 grid gap-6 lg:grid-cols-3">
                    {{-- Left: Tips / Security --}}
                    <aside class="space-y-4 lg:col-span-1">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-sm font-black text-slate-900">Conseil</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Une photo + bio claire améliorent votre visibilité dans la recherche.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-5">
                            <h3 class="text-sm font-black text-slate-900">Sécurité</h3>
                            <p class="mt-1 text-sm text-slate-600">
                                Changement de mot de passe : utilise la page Breeze.
                            </p>
                            <a href="{{ route('profile.edit') }}"
                               class="mt-3 inline-flex w-full justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                                Ouvrir sécurité
                            </a>
                        </div>
                    </aside>

                    {{-- Right: Inputs --}}
                    <section class="lg:col-span-2 space-y-5">
                        {{-- Card: Identité --}}
                        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-black text-slate-900">Identité</h3>
                                <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Informations
                                </span>
                            </div>

                            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="text-xs font-black uppercase tracking-widest text-slate-500">Nom</label>
                                    <input
                                        name="nom"
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                                               focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                        value="{{ old('nom', $u->nom ?? '') }}"
                                    >
                                    @error('nom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="text-xs font-black uppercase tracking-widest text-slate-500">Prénom</label>
                                    <input
                                        name="prenom"
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                                               focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                        value="{{ old('prenom', $u->prenom ?? '') }}"
                                    >
                                    @error('prenom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Card: Profil --}}
                        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-black text-slate-900">Profil</h3>
                                <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Présentation
                                </span>
                            </div>

                            <div class="mt-5 grid gap-4">
                                <div>
                                    <label class="text-xs font-black uppercase tracking-widest text-slate-500">Biographie</label>
                                    <textarea
                                        name="biographie"
                                        rows="5"
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                                               focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                    >{{ old('biographie', $u->biographie ?? '') }}</textarea>
                                    @error('biographie') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="text-xs font-black uppercase tracking-widest text-slate-500">Image (url)</label>
                                        <input
                                            name="image"
                                            placeholder="https://..."
                                            value="{{ old('image', $u->image ?? '') }}"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                                                   focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                        >
                                        @error('image') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label class="text-xs font-black uppercase tracking-widest text-slate-500">Rôle</label>
                                        <select
                                            name="role"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm
                                                   focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                                        >
                                            <option value="RECHERCHEUR" @selected(old('role', is_object($u->role) ? ($u->role->value ?? $u->role->name) : $u->role) === 'RECHERCHEUR')>Chercheur</option>
                                            <option value="RECRUTEUR" @selected(old('role', is_object($u->role) ? ($u->role->value ?? $u->role->name) : $u->role) === 'RECRUTEUR')>Recruteur</option>
                                        </select>
                                        @error('role') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Mobile actions --}}
                        <div class="sm:hidden flex items-center gap-2">
                            <a href="{{ url('/dashboard') }}"
                               class="flex-1 inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="flex-1 inline-flex items-center justify-center rounded-xl bg-[#0a66c2] px-4 py-3 text-sm font-black text-white hover:bg-blue-700">
                                Enregistrer
                            </button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
