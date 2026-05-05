@extends('layouts.app')
@section('title', 'Nouvelle pièce')
@section('header', 'Nouvelle pièce')

@section('content')
<div class="max-w-2xl pt-2">
    <form method="POST" action="{{ route('pieces.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Identification</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Référence *</label><input type="text" name="reference" value="{{ old('reference') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="BSH-0986494081"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Nom *</label><input type="text" name="nom" value="{{ old('nom') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Plaquettes de frein avant"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Description</label><textarea name="description" rows="2" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none placeholder-[#555]" placeholder="Description détaillée...">{{ old('description') }}</textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Marque</label>
                    <select name="marque_id" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Sélectionner —</option>
                        @foreach($marques as $m)
                            <option value="{{ $m->id }}" {{ old('marque_id') == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Catégorie</label>
                    <select name="categorie_id" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Sélectionner —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Compatibilité véhicules</label><input type="text" name="compatibilite" value="{{ old('compatibilite') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Peugeot 308, Citroën C4..."></div>
        </div>

        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Prix & Stock</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Prix d'achat HT (€)</label><input type="number" name="prix_achat" value="{{ old('prix_achat', 0) }}" step="0.01" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Prix de vente HT (€) *</label><input type="number" name="prix_vente" value="{{ old('prix_vente', 0) }}" step="0.01" min="0" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Stock disponible *</label><input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Seuil d'alerte</label><input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', 5) }}" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Photo (optionnel)</label><input type="file" name="photo" accept="image/*" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-[#333] file:text-white file:text-xs"></div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Ajouter la pièce</button>
            <a href="{{ route('pieces.index') }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
