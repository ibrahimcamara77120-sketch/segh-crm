@extends('layouts.app')
@section('title', 'Nouvelle commande')
@section('header', 'Nouvelle commande')

@section('content')
<div class="max-w-4xl pt-2" x-data="commandeForm()">
    <form method="POST" action="{{ route('commandes.store') }}" class="space-y-5">
        @csrf

        <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Client & Véhicule</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Client *</label>
                    <select name="client_id" x-model="clientId" @change="loadVehicules()" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Sélectionner un client —</option>
                        @foreach($clients as $c)
                            <option value="{{ $c->id }}" {{ (request('client_id') == $c->id || (isset($client) && $client->id == $c->id)) ? 'selected' : '' }}>{{ $c->nom_complet }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Véhicule (optionnel)</label>
                    <select name="vehicule_id" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="">— Sélectionner —</option>
                        @if(isset($client))
                            @foreach($client->vehicules as $v)
                                <option value="{{ $v->id }}" {{ request('vehicule_id') == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} — {{ $v->marque }} {{ $v->modele }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Date de passage client</label>
                    <input type="date" name="date_passage" value="{{ old('date_passage') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
                <div>
                    <label class="block text-[#aaa] text-xs mb-1.5">Date de rendez-vous prévu</label>
                    <input type="date" name="date_rdv" value="{{ old('date_rdv') }}" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                </div>
            </div>
        </div>

        <div class="bg-[#111] border border-[#222] rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider">Pièces *</h3>
                <button type="button" @click="addLigne()" class="px-3 py-1.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-xs transition">+ Ajouter une pièce</button>
            </div>

            <div class="space-y-3">
                <template x-for="(ligne, i) in lignes" :key="i">
                    <div class="grid grid-cols-12 gap-2 items-start">
                        <div class="col-span-5">
                            <select :name="'pieces['+i+'][piece_id]'" x-model="ligne.piece_id" @change="updatePrix(i)" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                                <option value="">— Sélectionner une pièce —</option>
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
                        <div class="col-span-2 pt-2.5">
                            <span x-show="ligne.piece_id" class="inline-flex items-center gap-1 text-[11px] px-2 py-1 rounded"
                                :class="ligne.stock >= ligne.quantite ? 'bg-green-900/20 text-green-400 border border-green-400/20' : (ligne.stock > 0 ? 'bg-orange-900/20 text-orange-400 border border-orange-400/20' : 'bg-red-900/20 text-red-400 border border-red-400/20')">
                                <span class="w-1.5 h-1.5 rounded-full" :class="ligne.stock >= ligne.quantite ? 'bg-green-400' : (ligne.stock > 0 ? 'bg-orange-400' : 'bg-red-400')"></span>
                                <span x-text="ligne.stock >= ligne.quantite ? 'En stock' : (ligne.stock > 0 ? 'Partiel' : 'Rupture')"></span>
                            </span>
                        </div>
                        <div class="col-span-1 flex items-start pt-2">
                            <button type="button" @click="removeLigne(i)" x-show="lignes.length > 1" class="text-[#666] hover:text-red-400 transition mt-2.5">
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
                    <div class="flex justify-between text-white font-bold text-base border-t border-[#333] pt-1 mt-1"><dt>Total TTC</dt><dd x-text="totalTtc.toFixed(2) + ' €'" class="text-[#E53935]"></dd></div>
                </dl>
            </div>
        </div>

        <div class="bg-[#111] border border-[#222] rounded-xl p-6">
            <h3 class="text-[#E53935] font-semibold text-sm uppercase tracking-wider mb-4">Notes</h3>
            <textarea name="notes" rows="3" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none placeholder-[#555]" placeholder="Commentaires, instructions...">{{ old('notes') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Créer la commande</button>
            <a href="{{ route('commandes.index') }}" class="px-6 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Annuler</a>
        </div>
    </form>
</div>

<script>
const piecesData = @json($pieces->map(fn($p) => ['id' => $p->id, 'prix' => $p->prix_vente, 'stock' => $p->stock]));

function commandeForm() {
    return {
        lignes: [{ piece_id: '', quantite: 1, prix: 0, stock: 0 }],
        totalHt: 0, tva: 0, totalTtc: 0, clientId: '{{ request("client_id") ?? "" }}',
        addLigne() { this.lignes.push({ piece_id: '', quantite: 1, prix: 0, stock: 0 }); },
        removeLigne(i) { this.lignes.splice(i, 1); this.calcTotal(); },
        updatePrix(i) {
            const p = piecesData.find(x => x.id == this.lignes[i].piece_id);
            if (p) { this.lignes[i].prix = p.prix; this.lignes[i].stock = p.stock; }
            this.calcTotal();
        },
        calcTotal() {
            this.totalHt = this.lignes.reduce((s, l) => s + (parseFloat(l.prix)||0) * (parseInt(l.quantite)||0), 0);
            this.tva = this.totalHt * 0.20;
            this.totalTtc = this.totalHt + this.tva;
        },
        loadVehicules() { /* Could be enhanced with AJAX */ }
    }
}
</script>
@endsection
