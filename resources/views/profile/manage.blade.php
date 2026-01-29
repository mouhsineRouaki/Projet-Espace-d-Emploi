<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Gestion du profil</h2>
                <p class="text-sm text-slate-500">UI statique (tu branches DB après).</p>
            </div>
        </div>
    </x-slot>

    @php $u = Auth::user(); @endphp

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left -->
        <aside class="space-y-4">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-2xl bg-slate-200"></div>
                    <div class="min-w-0">
                        <div class="font-semibold truncate">
                            {{ trim(($u->prenom ?? '').' '.($u->nom ?? ($u->name ?? 'Utilisateur'))) }}
                        </div>
                        <div class="text-xs text-slate-500 truncate">{{ $u->email ?? '' }}</div>
                    </div>
                </div>
                <div class="mt-4 grid gap-2">
                    <button class="rounded-xl bg-[#0a66c2] px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
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
                        <input class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                               value="{{ $u->nom ?? '' }}">
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Prénom</label>
                        <input class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]"
                               value="{{ $u->prenom ?? '' }}">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Biographie</label>
                        <textarea rows="4" class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]">{{ $u->biographie ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Image (URL)</label>
                        <input placeholder="https://..." class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]">
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Rôle</label>
                        <select class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-100/70 px-4 py-2.5 text-sm focus:border-[#0a66c2] focus:ring-[#0a66c2]">
                            <option value="RECHERCHEUR" @selected(($u->role ?? '')==='RECHERCHEUR')>Chercheur</option>
                            <option value="RECRUTEUR" @selected(($u->role ?? '')==='RECRUTEUR')>Recruteur</option>
                        </select>
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
    </div>
</x-app-layout>
