@extends('layouts.app')
@section('title', 'Nouveau client')
@section('header', 'Nouveau client')

@section('content')
<div class="max-w-2xl pt-2" x-data="{ type: '{{ $type }}' }">
    {{-- Type selector --}}
    <div class="flex gap-3 mb-6">
        <button type="button" @click="type='particulier'" :class="type==='particulier' ? 'bg-blue-600 text-white border-blue-600' : 'bg-[#1A1A1A] text-[#aaa] border-[#333]'" class="flex-1 py-3 rounded-xl border-2 font-medium transition text-sm">
            Particulier
        </button>
        <button type="button" @click="type='professionnel'" :class="type==='professionnel' ? 'bg-orange-600 text-white border-orange-600' : 'bg-[#1A1A1A] text-[#aaa] border-[#333]'" class="flex-1 py-3 rounded-xl border-2 font-medium transition text-sm">
            Professionnel
        </button>
    </div>

    <form method="POST" action="{{ route('clients.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="type" :value="type">

        {{-- Particulier fields --}}
        <div x-show="type==='particulier'" class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-white font-semibold text-sm uppercase tracking-wider text-[#E53935]">Informations personnelles</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Civilité</label>
                    <select name="civilite" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="M.">M.</option>
                        <option value="Mme">Mme</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Jean">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Dupont">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Source</label>
                    <select name="source" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Sélectionner —</option>
                        <option value="Bouche à oreille">Bouche à oreille</option>
                        <option value="Site web">Site web</option>
                        <option value="Google">Google</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Professionnel fields --}}
        <div x-show="type==='professionnel'" class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-white font-semibold text-sm uppercase tracking-wider text-[#E53935]">Informations entreprise</h3>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Raison sociale *</label>
                <input type="text" name="raison_sociale" value="{{ old('raison_sociale') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Garage Auto Express">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Contact — Nom</label>
                    <input type="text" name="contact_nom" value="{{ old('contact_nom') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Moreau">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Contact — Prénom</label>
                    <input type="text" name="contact_prenom" value="{{ old('contact_prenom') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Thierry">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Poste</label>
                    <input type="text" name="contact_poste" value="{{ old('contact_poste') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Gérant">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">SIRET (14 chiffres)</label>
                    <input type="text" name="siret" value="{{ old('siret') }}" maxlength="14" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] font-mono placeholder-[#555]" placeholder="12345678901234">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">N° TVA intracommunautaire</label>
                    <input type="text" name="tva_intra" value="{{ old('tva_intra') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] font-mono placeholder-[#555]" placeholder="FR12345678901">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Remise commerciale (%)</label>
                    <input type="number" name="remise_pct" value="{{ old('remise_pct', 0) }}" min="0" max="100" step="0.5" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Conditions de règlement</label>
                    <select name="conditions_reglement" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="comptant">Comptant</option>
                        <option value="30_jours">30 jours</option>
                        <option value="60_jours">60 jours</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Source</label>
                    <select name="source" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="Prospection">Prospection</option>
                        <option value="Partenaire">Partenaire</option>
                        <option value="Site web">Site web</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">IBAN (optionnel)</label>
                <input type="text" name="iban" value="{{ old('iban') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] font-mono placeholder-[#555]" placeholder="FR76 3000 6000 0112 3456 7890 189">
            </div>
        </div>

        {{-- Common fields --}}
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-white font-semibold text-sm uppercase tracking-wider text-[#E53935]">Contact & Adresse</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="contact@email.fr">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Tél. mobile</label>
                    <input type="text" name="tel_mobile" value="{{ old('tel_mobile') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="06 12 34 56 78">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Tél. fixe</label>
                    <input type="text" name="tel_fixe" value="{{ old('tel_fixe') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="01 64 12 34 56">
                </div>
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="12 rue des Merisiers">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Complément</label>
                    <input type="text" name="complement_adresse" value="{{ old('complement_adresse') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Bât. B">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Code postal</label>
                    <input type="text" name="code_postal" value="{{ old('code_postal') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="77120">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Ville</label>
                    <input type="text" name="ville" value="{{ old('ville') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Mouroux">
                </div>
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Notes internes</label>
                <textarea name="notes" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555] resize-none" placeholder="Informations internes...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">
                Créer le client
            </button>
            <a href="{{ route('clients.index') }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection
