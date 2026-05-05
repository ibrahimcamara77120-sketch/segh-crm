@extends('layouts.app')
@section('title', 'Modifier — ' . $commande->numero)
@section('header', 'Modifier la commande')

@section('content')
<div class="max-w-4xl pt-2" x-data="editCommandeForm()">
    <div class="flex items-center justify-between mb-5">
        <a href="{{ route('commandes.show', $commande) }}" class="text-[#666] hover:text-white transition text-sm">← {{ $commande->numero }}</a>
        <div class="flex gap-2">
            <a href="{{ route('commandes.pdf', $commande) }}?type=devis" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-xs transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Devis PDF
            </a>
            <a href="{{ route('commandes.pdf', $commande) }}?type=facture" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-xs transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Facture PDF
            </a>
        </div>
    </div>
    <form method="POST" action="{{ route('commandes.update', $commande) }}" class="space-y-5">
        @csrf @method('PUT')

        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Client & Véhicule</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Client *</label>
                    <select name="client_id" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ $commande->client_id == $c->id ? 'selected' : '' }}>{{ $c->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Véhicule</label>
                    <select name="vehicule_id" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Aucun —</option>
                        @foreach($commande->client->vehicules as $v)
                            <option value="{{ $v->id }}" {{ $commande->vehicule_id == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} — {{ $v->marque }} {{ $v->modele }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Date de passage</label>
                    <input type="date" name="date_passage" value="{{ old('date_passage', $commande->date_passage?->format('Y-m-d')) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Date RDV</label>
                    <input type="date" name="date_rdv" value="{{ old('date_rdv', $commande->date_rdv?->format('Y-m-d')) }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
            </div>
        </div>

        <div class="bg-[#111] border border-[#222] rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Pièces</h3>
                <button type="button" @click="addLigne()" class="px-3 py-1.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-xs transition">+ Ajouter</button>
            </div>
            <div class="space-y-3">
                <template x-for="(ligne, i) in lignes" :key="i">
                    <div class="grid grid-cols-12 gap-2 items-start">
                        <div class="col-span-5">
                            <select :name="'pieces['+i+'][piece_id]'" x-model="ligne.piece_id" @change="updatePrix(i)" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                                <option value="">— Sélectionner —</option>
                                @foreach($pieces as $p)
                                    <option value="{{ $p->id }}" data-prix="{{ $p->prix_vente }}" data-stock="{{ $p->stock }}">{{ $p->reference }} — {{ $p->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <input type="number" :name="'pieces['+i+'][quantite]'" x-model="ligne.quantite" @input="calcTotal()" min="1" placeholder="Qté" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        </div>
                        <div class="col-span-2">
                            <input type="number" :name="'pieces['+i+'][prix_unitaire]'" x-model="ligne.prix" @input="calcTotal()" step="0.01" min="0" placeholder="Prix HT" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        </div>
                        <div class="col-span-2 pt-2.5" x-show="ligne.piece_id">
                            <span class="inline-flex items-center gap-1 text-[11px] px-2 py-1 rounded"
                                :class="ligne.stock >= ligne.quantite ? 'bg-green-900/20 text-green-400 border border-green-400/20' : (ligne.stock > 0 ? 'bg-orange-900/20 text-orange-400 border border-orange-400/20' : 'bg-red-900/20 text-red-400 border border-red-400/20')">
                                <span class="w-1.5 h-1.5 rounded-full" :class="ligne.stock >= ligne.quantite ? 'bg-green-400' : (ligne.stock > 0 ? 'bg-orange-400' : 'bg-red-400')"></span>
                                <span x-text="ligne.stock >= ligne.quantite ? 'En stock' : (ligne.stock > 0 ? 'Partiel' : 'Rupture')"></span>
                            </span>
                        </div>
                        <div class="col-span-1 flex items-start pt-2.5">
                            <button type="button" @click="removeLigne(i)" x-show="lignes.length > 1" class="text-[#666] hover:text-red-400 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            <div class="mt-6 pt-4 border-t border-[#222] flex justify-end">
                <dl class="space-y-1 text-sm min-w-[200px]">
                    <div class="flex justify-between text-[#aaa]"><dt>Total HT</dt><dd x-text="totalHt.toFixed(2) + ' €'"></dd></div>
                    <div class="flex justify-between text-[#aaa]"><dt>TVA (20%)</dt><dd x-text="tva.toFixed(2) + ' €'"></dd></div>
                    <div class="flex justify-between text-white font-bold text-base border-t border-[#333] pt-1 mt-1">
                        <dt>Total TTC</dt><dd x-text="totalTtc.toFixed(2) + ' €'" class="text-[#E53935]"></dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-[#111] border border-[#222] rounded-xl p-6">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider mb-4">Notes</h3>
            <textarea name="notes" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none">{{ old('notes', $commande->notes) }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer</button>
            <a href="{{ route('commandes.show', $commande) }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>

@php
$piecesMapEdit = $pieces->map(fn($p) => ['id' => $p->id, 'prix' => $p->prix_vente, 'stock' => $p->stock]);
$existingLignesMap = $commande->commandePieces->map(fn($cp) => ['piece_id' => (string)$cp->piece_id, 'quantite' => $cp->quantite, 'prix' => $cp->prix_unitaire, 'stock' => $cp->piece->stock]);
@endphp
<script>
const piecesDataEdit = @json($piecesMapEdit);
const existingLignes = @json($existingLignesMap);

function editCommandeForm() {
    return {
        lignes: existingLignes.length ? existingLignes : [{ piece_id: '', quantite: 1, prix: 0, stock: 0 }],
        totalHt: 0, tva: 0, totalTtc: 0,
        init() { this.calcTotal(); },
        addLigne() { this.lignes.push({ piece_id: '', quantite: 1, prix: 0, stock: 0 }); },
        removeLigne(i) { this.lignes.splice(i, 1); this.calcTotal(); },
        updatePrix(i) {
            const p = piecesDataEdit.find(x => x.id == this.lignes[i].piece_id);
            if (p) { this.lignes[i].prix = p.prix; this.lignes[i].stock = p.stock; }
            this.calcTotal();
        },
        calcTotal() {
            this.totalHt = this.lignes.reduce((s, l) => s + (parseFloat(l.prix)||0) * (parseInt(l.quantite)||0), 0);
            this.tva = this.totalHt * 0.20;
            this.totalTtc = this.totalHt + this.tva;
        }
    }
}
</script>
@endsection
