@extends('layouts.app')
@section('title', 'Modifier — ' . $vehicule->immatriculation)
@section('header', 'Modifier le véhicule')

@section('content')
<div class="max-w-xl pt-2">
    <a href="{{ route('clients.vehicules.show', [$client, $vehicule]) }}" class="text-[#666] hover:text-white transition text-sm block mb-6">← {{ $vehicule->immatriculation }}</a>

    <form method="POST" action="{{ route('clients.vehicules.update', [$client, $vehicule]) }}" class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-[#aaa] text-xs mb-1.5">Immatriculation *</label><input type="text" name="immatriculation" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono font-bold uppercase focus:outline-none focus:border-[#E53935]"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Marque *</label><input type="text" name="marque" value="{{ old('marque', $vehicule->marque) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Modèle *</label><input type="text" name="modele" value="{{ old('modele', $vehicule->modele) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Version</label><input type="text" name="version" value="{{ old('version', $vehicule->version) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Année</label><input type="number" name="annee" value="{{ old('annee', $vehicule->annee) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Carburant</label><select name="carburant" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"><option value="">—</option><option value="essence" {{ $vehicule->carburant === 'essence' ? 'selected' : '' }}>Essence</option><option value="diesel" {{ $vehicule->carburant === 'diesel' ? 'selected' : '' }}>Diesel</option><option value="hybride" {{ $vehicule->carburant === 'hybride' ? 'selected' : '' }}>Hybride</option><option value="electrique" {{ $vehicule->carburant === 'electrique' ? 'selected' : '' }}>Électrique</option></select></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Kilométrage</label><input type="number" name="km" value="{{ old('km', $vehicule->km) }}" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-[#aaa] text-xs mb-1.5">Couleur</label><input type="text" name="couleur" value="{{ old('couleur', $vehicule->couleur) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">VIN</label><input type="text" name="vin" value="{{ old('vin', $vehicule->vin) }}" maxlength="17" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935]"></div>
        </div>
        <div><label class="block text-[#aaa] text-xs mb-1.5">Notes mécaniques</label><textarea name="notes_meca" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none">{{ old('notes_meca', $vehicule->notes_meca) }}</textarea></div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer</button>
            <a href="{{ route('clients.vehicules.show', [$client, $vehicule]) }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
