@extends('layouts.app')
@section('title', 'Ajouter un véhicule')
@section('header', 'Ajouter un véhicule')

@section('content')
<div class="max-w-xl pt-2">
    <a href="{{ route('clients.vehicules.index', $client) }}" class="text-[#666] hover:text-white transition text-sm block mb-6">← {{ $client->nom_complet }}</a>

    <form method="POST" action="{{ route('clients.vehicules.store', $client) }}" class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-[#aaa] text-xs mb-1.5">Immatriculation *</label>
            <input type="text" name="immatriculation" value="{{ old('immatriculation') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono font-bold uppercase focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="AB-123-CD">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Marque *</label><input type="text" name="marque" value="{{ old('marque') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Peugeot"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Modèle *</label><input type="text" name="modele" value="{{ old('modele') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="308"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Version / Finition</label><input type="text" name="version" value="{{ old('version') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="GT Line"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Année</label><input type="number" name="annee" value="{{ old('annee') }}" min="1990" max="{{ date('Y')+1 }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="{{ date('Y') }}"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Carburant</label>
                <select name="carburant" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                    <option value="">— Sélectionner —</option>
                    <option value="essence" {{ old('carburant') === 'essence' ? 'selected' : '' }}>Essence</option>
                    <option value="diesel" {{ old('carburant') === 'diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="hybride" {{ old('carburant') === 'hybride' ? 'selected' : '' }}>Hybride</option>
                    <option value="electrique" {{ old('carburant') === 'electrique' ? 'selected' : '' }}>Électrique</option>
                </select>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Kilométrage</label><input type="number" name="km" value="{{ old('km') }}" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="50000"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Couleur</label><input type="text" name="couleur" value="{{ old('couleur') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Blanc nacré"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Numéro VIN (17 car.)</label><input type="text" name="vin" value="{{ old('vin') }}" maxlength="17" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="VF1234567890"></div>
        </div>
        <div><label class="block text-[#aaa] text-xs mb-1.5">Notes mécaniques</label><textarea name="notes_meca" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none placeholder-[#555]" placeholder="Ex: plaquettes avant usées, courroie à surveiller...">{{ old('notes_meca') }}</textarea></div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer le véhicule</button>
            <a href="{{ route('clients.vehicules.index', $client) }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
