<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Gestion du profil</h2>
                <p class="text-sm text-slate-500">Modifier et enregistrer vos informations.</p>
            </div>
        </div>
    </x-slot>

    @php $u = $u ?? Auth::user(); @endphp

    @if(session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.manage.update') }}" class="grid gap-6 lg:grid-cols-3">
        @csrf
        @method('PATCH')

        <!-- Left -->
        <aside class="space-y-4">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <img src="{{ $u->image ?? 'https://i.pravatar.cc/150?img=3' }}" class="h-12 w-12 rounded-2xl bg-slate-200 object-cover"/>
                    <div class="min-w-0">
                        <div class="font-semibold truncate">
                            {{ trim(($u->prenom ?? '').' '.($u->nom ?? 'Utilisateur')) }}
                        </div>
                        <div class="text-xs text-slate-500 truncate">{{ $u->email ?? '' }}</div>
                    </div>
                </div>

                <div class="mt-4 grid gap-2">
                    <button type="submit" class="rounded-xl bg-[#0a66c2] px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Enregistrer
                    </button>

                    <a href="{{ url('/dashboard') }}" class="text-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Annuler
                    </a>
                </div>
            </div>
        </aside>

        <!-- Form -->
        <section class="lg:col-span-2">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-5">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Nom</label>
                        <input
                            name="nom"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                            value="{{ old('nom', $u->nom ?? '') }}"
                        >
                        @error('nom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Prénom</label>
                        <input
                            name="prenom"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                            value="{{ old('prenom', $u->prenom ?? '') }}"
                        >
                        @error('prenom') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Biographie</label>
                        <textarea
                            name="biographie"
                            rows="4"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                        >{{ old('biographie', $u->biographie ?? '') }}</textarea>
                        @error('biographie') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Image (url)</label>
                        <input
                            name="image"
                            placeholder="https://..."
                            value="{{ old('image', $u->image ?? '') }}"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                        >
                        @error('image') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Rôle</label>
                        <select
                            name="role"
                            class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                        >
                            <option value="RECHERCHEUR" @selected(old('role', is_object($u->role) ? ($u->role->value ?? $u->role->name) : $u->role) === 'RECHERCHEUR')>Chercheur</option>
                            <option value="RECRUTEUR" @selected(old('role', is_object($u->role) ? ($u->role->value ?? $u->role->name) : $u->role) === 'RECRUTEUR')>Recruteur</option>
                        </select>
                        @error('role') <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="rounded-2xl bg-slate-50 border border-slate-200/70 p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Sécurité</h3>
                    <p class="mt-1 text-sm text-slate-600">
                        Changement de mot de passe : utilise la page Breeze.
                    </p>
                    <a href="{{ route('profile.edit') }}" class="mt-3 inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                        Ouvrir sécurité
                    </a>
                </div>
            </div>
        </section>
    </form>
</x-app-layout>
