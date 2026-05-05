@extends('layouts.app')
@section('title', $commande->numero)
@section('header', $commande->numero)

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-4">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="font-mono font-bold text-white text-xl">{{ $commande->numero }}</span>
                    <x-badge-statut :statut="$commande->statut" />
                    <x-badge-paiement :statut="$commande->statut_paiement" />
                    @if($commande->commande_incomplete)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-orange-900/20 text-orange-400 border border-orange-400/20">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Pièces manquantes
                        </span>
                    @endif
                </div>
                <p class="text-[#555] text-sm mt-1">
                    <a href="{{ route('clients.show', $commande->client) }}" class="hover:text-[#E53935] transition">{{ $commande->client->nom_complet }}</a>
                    @if($commande->vehicule) — <span class="font-mono">{{ $commande->vehicule->immatriculation }}</span>@endif
                    — {{ $commande->created_at->format('d/m/Y') }}
                </p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('commandes.pdf', $commande) }}?type=devis" target="_blank" class="flex items-center gap-1.5 px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Devis
            </a>
            <a href="{{ route('commandes.pdf', $commande) }}?type=facture" target="_blank" class="flex items-center gap-1.5 px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Facture
            </a>
            <a href="{{ route('commandes.edit', $commande) }}" class="px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Modifier</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-5">
        {{-- Left: order details --}}
        <div class="col-span-2 space-y-4">
            {{-- Items --}}
            <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-[#222]">
                    <h3 class="text-white font-semibold">Pièces commandées</h3>
                    @php $dispo = $commande->commandePieces->where('disponible_sur_place', true)->count(); $total = $commande->commandePieces->count(); @endphp
                    <p class="text-[#555] text-xs mt-0.5">Disponibles sur place : <span class="{{ $dispo === $total ? 'text-green-400' : 'text-orange-400' }} font-medium">{{ $dispo }}/{{ $total }}</span></p>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2.5 text-left">Pièce</th>
                            <th class="px-4 py-2.5 text-center">Qté</th>
                            <th class="px-4 py-2.5 text-right">Prix u. HT</th>
                            <th class="px-4 py-2.5 text-right">Total HT</th>
                            <th class="px-4 py-2.5 text-center">Dispo</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1A1A1A]">
                        @foreach($commande->commandePieces as $cp)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="text-white font-medium">{{ $cp->piece->nom }}</p>
                                <p class="text-[#555] text-xs font-mono">{{ $cp->piece->reference }}</p>
                            </td>
                            <td class="px-4 py-3 text-center text-white">{{ $cp->quantite }}</td>
                            <td class="px-4 py-3 text-right text-[#aaa]">{{ number_format($cp->prix_unitaire, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-3 text-right text-white font-medium">{{ number_format($cp->prix_unitaire * $cp->quantite, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-3 text-center">
                                @if($cp->disponible_sur_place)
                                    <svg class="w-4 h-4 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    <svg class="w-4 h-4 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-[#1A1A1A]">
                        <tr><td colspan="3" class="px-4 py-2.5 text-right text-[#666] text-xs">Sous-total HT</td><td class="px-4 py-2.5 text-right text-[#aaa]">{{ number_format($commande->total_ht, 2, ',', ' ') }} €</td><td></td></tr>
                        <tr><td colspan="3" class="px-4 py-2 text-right text-[#666] text-xs">TVA (20%)</td><td class="px-4 py-2 text-right text-[#aaa]">{{ number_format($commande->tva, 2, ',', ' ') }} €</td><td></td></tr>
                        <tr><td colspan="3" class="px-4 py-3 text-right text-white font-bold">Total TTC</td><td class="px-4 py-3 text-right text-[#E53935] font-bold text-lg">{{ number_format($commande->total_ttc, 2, ',', ' ') }} €</td><td></td></tr>
                    </tfoot>
                </table>
            </div>

            {{-- Change status --}}
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-3">Changer le statut</h3>
                <form method="POST" action="{{ route('commandes.statut', $commande) }}" class="flex gap-2">
                    @csrf @method('PATCH')
                    <select name="statut" class="flex-1 bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                        <option value="en_attente" {{ $commande->statut === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmee" {{ $commande->statut === 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                        <option value="en_preparation" {{ $commande->statut === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                        <option value="prete" {{ $commande->statut === 'prete' ? 'selected' : '' }}>Prête à récupérer</option>
                        <option value="livree" {{ $commande->statut === 'livree' ? 'selected' : '' }}>Livrée</option>
                        <option value="annulee" {{ $commande->statut === 'annulee' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="px-4 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm transition">Mettre à jour</button>
                </form>
            </div>

            @if($commande->notes)
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-2">Notes</h3>
                <p class="text-[#aaa] text-sm">{{ $commande->notes }}</p>
            </div>
            @endif
        </div>

        {{-- Right: payment --}}
        <div class="space-y-4">
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-4">Paiement</h3>
                <dl class="space-y-3 text-sm mb-4">
                    <div class="flex justify-between"><dt class="text-[#555]">Total TTC</dt><dd class="text-white font-bold">{{ number_format($commande->total_ttc, 2, ',', ' ') }} €</dd></div>
                    <div class="flex justify-between"><dt class="text-[#555]">Déjà réglé</dt><dd class="text-green-400 font-bold">{{ number_format($commande->montant_paye, 2, ',', ' ') }} €</dd></div>
                    <div class="flex justify-between border-t border-[#222] pt-3"><dt class="text-[#aaa] font-medium">Reste dû</dt><dd class="text-[#E53935] font-bold text-lg">{{ number_format($commande->montant_restant, 2, ',', ' ') }} €</dd></div>
                </dl>

                @if($commande->paiements->isNotEmpty())
                <div class="mb-4">
                    <p class="text-[#555] text-xs uppercase tracking-wider mb-2">Historique paiements</p>
                    <div class="space-y-2">
                        @foreach($commande->paiements as $p)
                        <div class="flex items-center justify-between text-xs bg-[#1A1A1A] rounded-lg px-3 py-2">
                            <div>
                                <span class="text-white font-medium">{{ number_format($p->montant, 2, ',', ' ') }} €</span>
                                <span class="text-[#555] ml-1">{{ $p->mode }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-[#555]">{{ $p->date->format('d/m/Y') }}</p>
                                <p class="text-[#444]">{{ $p->user->name }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($commande->statut_paiement !== 'paye' && $commande->statut !== 'annulee')
                <div x-data="{ open: false }">
                    <button type="button" @click="open=!open" class="w-full py-2.5 bg-green-800 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition">
                        + Enregistrer un paiement
                    </button>
                    <div x-show="open" x-transition class="mt-3">
                        <form method="POST" action="{{ route('commandes.paiement', $commande) }}" class="space-y-3">
                            @csrf
                            <div><label class="block text-[#aaa] text-xs mb-1">Montant (€) *</label><input type="number" name="montant" step="0.01" min="0.01" value="{{ $commande->montant_restant }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#E53935]"></div>
                            <div><label class="block text-[#aaa] text-xs mb-1">Mode *</label><select name="mode" required class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#E53935]"><option value="especes">Espèces</option><option value="carte">Carte bancaire</option><option value="virement">Virement</option><option value="cheque">Chèque</option></select></div>
                            <div><label class="block text-[#aaa] text-xs mb-1">Date *</label><input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#E53935]"></div>
                            <div><label class="block text-[#aaa] text-xs mb-1">Référence</label><input type="text" name="reference" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="N° virement..."></div>
                            <button type="submit" class="w-full py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">Valider le paiement</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-3">Dates</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-[#555]">Créée le</dt><dd class="text-[#aaa]">{{ $commande->created_at->format('d/m/Y à H:i') }}</dd></div>
                    @if($commande->date_passage)<div class="flex justify-between"><dt class="text-[#555]">Passage client</dt><dd class="text-[#aaa]">{{ $commande->date_passage->format('d/m/Y') }}</dd></div>@endif
                    @if($commande->date_rdv)<div class="flex justify-between"><dt class="text-[#555]">RDV prévu</dt><dd class="{{ $commande->date_rdv->isToday() ? 'text-blue-400 font-medium' : 'text-[#aaa]' }}">{{ $commande->date_rdv->format('d/m/Y') }}</dd></div>@endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
