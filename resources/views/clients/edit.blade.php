@extends('layouts.app')
@section('title', 'Modifier — ' . $client->nom_complet)
@section('header', 'Modifier le client')

@section('content')
<div class="max-w-2xl pt-2">
    <form method="POST" action="{{ route('clients.update', $client) }}" class="space-y-6">
        @csrf @method('PUT')

        @if($client->is_pro)
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-orange-900/20 text-orange-400 border border-orange-400/20">PRO</span>
                <h3 class="text-white font-semibold text-sm">Informations entreprise</h3>
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Raison sociale *</label>
                <input type="text" name="raison_sociale" value="{{ old('raison_sociale', $client->raison_sociale) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Contact — Nom</label><input type="text" name="contact_nom" value="{{ old('contact_nom', $client->contact_nom) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Contact — Prénom</label><input type="text" name="contact_prenom" value="{{ old('contact_prenom', $client->contact_prenom) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Poste</label><input type="text" name="contact_poste" value="{{ old('contact_poste', $client->contact_poste) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">SIRET</label><input type="text" name="siret" value="{{ old('siret', $client->siret) }}" maxlength="14" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">TVA intra</label><input type="text" name="tva_intra" value="{{ old('tva_intra', $client->tva_intra) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Remise (%)</label><input type="number" name="remise_pct" value="{{ old('remise_pct', $client->remise_pct) }}" min="0" max="100" step="0.5" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Conditions règlement</label><select name="conditions_reglement" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"><option value="comptant" {{ $client->conditions_reglement === 'comptant' ? 'selected' : '' }}>Comptant</option><option value="30_jours" {{ $client->conditions_reglement === '30_jours' ? 'selected' : '' }}>30 jours</option><option value="60_jours" {{ $client->conditions_reglement === '60_jours' ? 'selected' : '' }}>60 jours</option></select></div>
            </div>
        </div>
        @else
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-blue-900/20 text-blue-400 border border-blue-400/20">PARTICULIER</span>
                <h3 class="text-white font-semibold text-sm">Informations personnelles</h3>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Civilité</label><select name="civilite" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"><option value="M." {{ $client->civilite === 'M.' ? 'selected' : '' }}>M.</option><option value="Mme" {{ $client->civilite === 'Mme' ? 'selected' : '' }}>Mme</option></select></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Prénom</label><input type="text" name="prenom" value="{{ old('prenom', $client->prenom) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Nom *</label><input type="text" name="nom" value="{{ old('nom', $client->nom) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
        </div>
        @endif

        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#aaa] font-semibold text-sm uppercase tracking-wider">Contact & Adresse</h3>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Email</label><input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Tél. mobile</label><input type="text" name="tel_mobile" value="{{ old('tel_mobile', $client->tel_mobile) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Tél. fixe</label><input type="text" name="tel_fixe" value="{{ old('tel_fixe', $client->tel_fixe) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Adresse</label><input type="text" name="adresse" value="{{ old('adresse', $client->adresse) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Complément</label><input type="text" name="complement_adresse" value="{{ old('complement_adresse', $client->complement_adresse) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Code postal</label><input type="text" name="code_postal" value="{{ old('code_postal', $client->code_postal) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Ville</label><input type="text" name="ville" value="{{ old('ville', $client->ville) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Notes internes</label><textarea name="notes" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none">{{ old('notes', $client->notes) }}</textarea></div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer</button>
            <a href="{{ route('clients.show', $client) }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
