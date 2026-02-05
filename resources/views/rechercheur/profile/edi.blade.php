<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Profil Chercheur</h2>
                <p class="text-sm text-slate-500">Gérer CV, formations, expériences et compétences.</p>
            </div>
        </div>
    </x-slot>

    @php
        $u = $u ?? Auth::user();
        $r = $u->rechercheur;
        $formations = $r?->formations ?? collect();
        $experiences = $r?->experiences ?? collect();
        $skills = $r?->skills ?? collect();

        $roleValue = is_object($u->role) ? ($u->role->value ?? $u->role->name ?? 'RECHERCHEUR') : ($u->role ?? 'RECHERCHEUR');
        $roleValue = strtoupper((string)$roleValue);
    @endphp

    @if(session('status'))
        <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        <!-- LEFT -->
        <aside class="space-y-4">
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <div class="flex items-center gap-3">
                    <img src="{{ $u->image ?? 'https://i.pravatar.cc/150?img=3' }}" class="h-12 w-12 rounded-2xl object-cover bg-slate-100" />
                    <div class="min-w-0">
                        <div class="font-semibold truncate">{{ trim(($u->prenom ?? '').' '.($u->nom ?? 'Utilisateur')) }}</div>
                        <div class="text-xs text-slate-500 truncate">{{ $u->email }}</div>
                    </div>
                </div>
                <div class="mt-4 text-xs font-semibold text-slate-500">
                    Rôle: <span class="text-slate-900">{{ $roleValue }}</span>
                </div>
            </div>

            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-5">
                <h3 class="text-sm font-semibold text-slate-900">Astuce</h3>
                <p class="mt-1 text-sm text-slate-600">
                    Ajoute des compétences + une spécialité claire pour mieux matcher les offres.
                </p>
            </div>
        </aside>

        <!-- MAIN -->
        <section class="lg:col-span-2 space-y-6">

            <!-- 1) INFOS USER + RECHERCHEUR -->
            <form method="POST" action="{{ route('rechercheur.profile.update') }}"
                  class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-5">
                @csrf
                @method('PATCH')

                <h3 class="text-sm font-semibold text-slate-900">Informations générales</h3>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Nom</label>
                        <input name="nom" value="{{ old('nom', $u->nom) }}"
                               class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Prénom</label>
                        <input name="prenom" value="{{ old('prenom', $u->prenom) }}"
                               class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Biographie</label>
                        <textarea name="biographie" rows="4"
                                  class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">{{ old('biographie', $u->biographie) }}</textarea>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Image (url)</label>
                        <input name="image" value="{{ old('image', $u->image) }}"
                               class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700">Rôle</label>
                        <select name="role"
                                class="mt-1 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
                            <option value="RECHERCHEUR" @selected(old('role', $roleValue)==='RECHERCHEUR')>Chercheur</option>
                            <option value="RECRUTEUR" @selected(old('role', $roleValue)==='RECRUTEUR')>Recruteur</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <h3 class="text-sm font-semibold text-slate-900">Profil Chercheur</h3>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">Titre du profil</label>
                            <input name="titre_profil" value="{{ old('titre_profil', $r->titre_profil ?? '') }}"
                                   class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Spécialité</label>
                            <input name="specialite" value="{{ old('specialite', $r->specialite ?? '') }}"
                                   class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Ville</label>
                            <input name="ville" value="{{ old('ville', $r->ville ?? '') }}"
                                   class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-sm font-semibold text-slate-700">CV (url/path)</label>
                            <input name="cv_path" value="{{ old('cv_path', $r->cv_path ?? '') }}"
                                   class="mt-1 w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button class="rounded-xl bg-[#0a66c2] px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Enregistrer
                    </button>
                </div>
            </form>

            <!-- 2) FORMATIONS -->
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-900">Formations</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $formations->count() }}</span>
                </div>

                <!-- add -->
                <form method="POST" action="{{ route('rechercheur.formations.store') }}" class="grid gap-3 sm:grid-cols-2">
                    @csrf
                    <input name="diplome" placeholder="Diplôme" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input name="ecole" placeholder="École" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input name="annee_obtention" placeholder="Année (ex: 2022)" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input name="description" placeholder="Description (optionnel)" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <div class="sm:col-span-2 flex justify-end">
                        <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                            Ajouter
                        </button>
                    </div>
                </form>

                <!-- list/edit -->
                <div class="space-y-4">
                    @foreach($formations as $f)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <form method="POST" action="{{ route('rechercheur.formations.update', $f->id) }}" class="grid gap-3 sm:grid-cols-2">
                                @csrf
                                @method('PATCH')
                                <input name="diplome" value="{{ $f->diplome }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input name="ecole" value="{{ $f->ecole }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input name="annee_obtention" value="{{ $f->annee_obtention }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input name="description" value="{{ $f->description }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />

                                <div class="sm:col-span-2 flex items-center justify-end gap-2">
                                    <button class="rounded-xl bg-[#0a66c2] px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                                        Modifier
                                    </button>
                            </form>

                                    <form method="POST" action="{{ route('rechercheur.formations.destroy', $f->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3) EXPERIENCES -->
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-900">Expériences</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $experiences->count() }}</span>
                </div>

                <!-- add -->
                <form method="POST" action="{{ route('rechercheur.experiences.store') }}" class="grid gap-3 sm:grid-cols-2">
                    @csrf
                    <input name="poste" placeholder="Poste" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input name="entreprise" placeholder="Entreprise" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input type="date" name="date_debut" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <input type="date" name="date_fin" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />

                    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 sm:col-span-2">
                        <input type="checkbox" name="en_poste" value="1" class="rounded border-slate-300">
                        En poste actuellement (date_fin sera ignorée)
                    </label>

                    <textarea name="description" rows="2" placeholder="Description (optionnel)"
                              class="sm:col-span-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm"></textarea>

                    <div class="sm:col-span-2 flex justify-end">
                        <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                            Ajouter
                        </button>
                    </div>
                </form>

                <!-- list/edit -->
                <div class="space-y-4">
                    @foreach($experiences as $e)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <form method="POST" action="{{ route('rechercheur.experiences.update', $e->id) }}" class="grid gap-3 sm:grid-cols-2">
                                @csrf
                                @method('PATCH')

                                <input name="poste" value="{{ $e->poste }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input name="entreprise" value="{{ $e->entreprise }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input type="date" name="date_debut" value="{{ optional($e->date_debut)->format('Y-m-d') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />
                                <input type="date" name="date_fin" value="{{ optional($e->date_fin)->format('Y-m-d') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm" />

                                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700 sm:col-span-2">
                                    <input type="checkbox" name="en_poste" value="1" @checked($e->en_poste) class="rounded border-slate-300">
                                    En poste actuellement
                                </label>

                                <textarea name="description" rows="2" class="sm:col-span-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm">{{ $e->description }}</textarea>

                                <div class="sm:col-span-2 flex items-center justify-end gap-2">
                                    <button class="rounded-xl bg-[#0a66c2] px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                                        Modifier
                                    </button>
                            </form>

                                    <form method="POST" action="{{ route('rechercheur.experiences.destroy', $e->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-rose-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4) SKILLS -->
            <div class="rounded-2xl bg-white border border-slate-200/70 shadow-sm p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-slate-900">Compétences</h3>
                    <span class="text-xs font-bold text-slate-500">{{ $skills->count() }}</span>
                </div>

                <!-- add skill -->
                <form method="POST" action="{{ route('rechercheur.skills.attach') }}" class="grid gap-3 sm:grid-cols-3">
                    @csrf
                    <input name="skill_name" placeholder="Ex: Laravel" class="sm:col-span-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm" />
                    <select name="niveau" class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm">
                        <option value="">Niveau</option>
                        <option value="DEBUTANT">Débutant</option>
                        <option value="INTERMEDIAIRE">Intermédiaire</option>
                        <option value="AVANCE">Avancé</option>
                        <option value="EXPERT">Expert</option>
                    </select>
                    <div class="sm:col-span-3 flex justify-end">
                        <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
                            Ajouter
                        </button>
                    </div>
                </form>

                <!-- list skills -->
                <div class="space-y-3">
                    @foreach($skills as $s)
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900">{{ $s->nom }}</div>
                                <div class="text-xs text-slate-500">Niveau: {{ $s->pivot->niveau ?? '—' }}</div>
                            </div>

                            <div class="flex items-center gap-2">
                                <form method="POST" action="{{ route('rechercheur.skills.update', $s->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="niveau" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm">
                                        <option value="">—</option>
                                        <option value="DEBUTANT" @selected(($s->pivot->niveau ?? '')==='DEBUTANT')>Débutant</option>
                                        <option value="INTERMEDIAIRE" @selected(($s->pivot->niveau ?? '')==='INTERMEDIAIRE')>Intermédiaire</option>
                                        <option value="AVANCE" @selected(($s->pivot->niveau ?? '')==='AVANCE')>Avancé</option>
                                        <option value="EXPERT" @selected(($s->pivot->niveau ?? '')==='EXPERT')>Expert</option>
                                    </select>
                                    <button class="ms-2 rounded-xl bg-[#0a66c2] px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                        OK
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('rechercheur.skills.detach', $s->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-xl bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-700">
                                        X
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </section>
    </div>
</x-app-layout>
