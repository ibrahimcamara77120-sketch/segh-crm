@extends('layouts.app')
@section('title', 'Commandes')
@section('header', 'Commandes')

@section('content')
<div class="pt-2">
    <div class="flex items-center justify-between mb-6">
        <div></div>
        <a href="{{ route('commandes.create') }}" class="px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">+ Nouvelle commande</a>
    </div>

    <form method="GET" class="bg-[#111] border border-[#222] rounded-xl p-4 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="N° commande, client..." class="bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]">
            <select name="statut" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                <option value="">Tous statuts</option>
                <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                <option value="confirmee" {{ request('statut') === 'confirmee' ? 'selected' : '' }}>Confirmée</option>
                <option value="en_preparation" {{ request('statut') === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                <option value="prete" {{ request('statut') === 'prete' ? 'selected' : '' }}>Prête</option>
                <option value="livree" {{ request('statut') === 'livree' ? 'selected' : '' }}>Livrée</option>
                <option value="annulee" {{ request('statut') === 'annulee' ? 'selected' : '' }}>Annulée</option>
            </select>
            <select name="statut_paiement" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                <option value="">Tous paiements</option>
                <option value="non_paye" {{ request('statut_paiement') === 'non_paye' ? 'selected' : '' }}>Non payé</option>
                <option value="acompte" {{ request('statut_paiement') === 'acompte' ? 'selected' : '' }}>Acompte</option>
                <option value="paye" {{ request('statut_paiement') === 'paye' ? 'selected' : '' }}>Payé</option>
            </select>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm transition">Filtrer</button>
                <a href="{{ route('commandes.index') }}" class="px-3 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Reset</a>
            </div>
        </div>
    </form>

    <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">N° Commande</th>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Véhicule</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Paiement</th>
                    <th class="px-4 py-3 text-right">Total TTC</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">RDV</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1A1A1A]">
                @forelse($commandes as $commande)
                <tr class="hover:bg-[#1A1A1A] transition group {{ $commande->commande_incomplete ? 'border-l-2 border-l-orange-600' : '' }}">
                    <td class="px-4 py-3">
                        <a href="{{ route('commandes.show', $commande) }}" class="text-[#E53935] hover:underline font-mono text-xs font-bold">{{ $commande->numero }}</a>
                        @if($commande->commande_incomplete)
                            <svg class="w-3.5 h-3.5 text-orange-400 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" title="Pièces manquantes"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('clients.show', $commande->client) }}" class="text-white hover:text-[#E53935] transition">{{ $commande->client->nom_complet }}</a>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-[#aaa]">{{ $commande->vehicule?->immatriculation ?? '—' }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$commande->statut" /></td>
                    <td class="px-4 py-3"><x-badge-paiement :statut="$commande->statut_paiement" /></td>
                    <td class="px-4 py-3 text-right font-semibold text-white">{{ number_format($commande->total_ttc, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-3 text-[#aaa] text-xs">{{ $commande->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 text-[#aaa] text-xs">
                        @if($commande->date_rdv)
                            <span class="{{ $commande->date_rdv->isToday() ? 'text-blue-400 font-medium' : '' }}">
                                {{ $commande->date_rdv->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-[#444]">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('commandes.show', $commande) }}" class="text-[#666] hover:text-white transition text-xs">Voir</a>
                            <a href="{{ route('commandes.pdf', $commande) }}" class="text-[#666] hover:text-blue-400 transition text-xs" target="_blank">PDF</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-4 py-12 text-center text-[#555]">Aucune commande trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $commandes->links() }}</div>
</div>
@endsection
