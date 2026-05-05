@extends('layouts.app')
@section('title', 'Modifier — ' . $piece->nom)
@section('header', 'Modifier la pièce')

@section('content')
<div class="max-w-2xl pt-2">
    <form method="POST" action="{{ route('pieces.update', $piece) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Identification</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Référence *</label><input type="text" name="reference" value="{{ old('reference', $piece->reference) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm font-mono focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Nom *</label><input type="text" name="nom" value="{{ old('nom', $piece->nom) }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Description</label><textarea name="description" rows="2" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none">{{ old('description', $piece->description) }}</textarea></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Marque</label><select name="marque_id" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"><option value="">— Sélectionner —</option>@foreach($marques as $m)<option value="{{ $m->id }}" {{ old('marque_id', $piece->marque_id) == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>@endforeach</select></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Catégorie</label><select name="categorie_id" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"><option value="">— Sélectionner —</option>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('categorie_id', $piece->categorie_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>@endforeach</select></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Compatibilité</label><input type="text" name="compatibilite" value="{{ old('compatibilite', $piece->compatibilite) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
        </div>
        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Prix & Stock</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Prix achat HT (€)</label><input type="number" name="prix_achat" value="{{ old('prix_achat', $piece->prix_achat) }}" step="0.01" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Prix vente HT (€) *</label><input type="number" name="prix_vente" value="{{ old('prix_vente', $piece->prix_vente) }}" step="0.01" min="0" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[#aaa] text-xs mb-1.5">Stock</label><input type="number" name="stock" value="{{ old('stock', $piece->stock) }}" min="0" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
                <div><label class="block text-[#aaa] text-xs mb-1.5">Seuil d'alerte</label><input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', $piece->seuil_alerte) }}" min="0" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]"></div>
            </div>
            <div><label class="block text-[#aaa] text-xs mb-1.5">Nouvelle photo</label><input type="file" name="photo" accept="image/*" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-[#333] file:text-white file:text-xs"></div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer</button>
            <a href="{{ route('pieces.show', $piece) }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>
@endsection
