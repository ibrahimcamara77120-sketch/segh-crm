@extends('layouts.app')
@section('title', 'Historique — ' . $client->nom_complet)
@section('header', 'Historique pièces — ' . $client->nom_complet)

@section('content')
<div class="pt-2 space-y-4">
    <div class="flex items-center gap-3">
        <a href="{{ route('clients.show', $client) }}" class="text-[#666] hover:text-white transition text-sm">← Retour fiche client</a>
    </div>

    <form method="GET" class="bg-[#111] border border-[#222] rounded-xl p-4 flex gap-3">
        <select name="vehicule_id" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
            <option value="">Tous les véhicules</option>
            @foreach($client->vehicules as $v)
            <option value="{{ $v->id }}" {{ request('vehicule_id') == $v->id ? 'selected' : '' }}>{{ $v->immatriculation }} — {{ $v->marque }} {{ $v->modele }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 bg-[#E53935] text-white rounded-lg text-sm">Filtrer</button>
        <a href="{{ route('clients.historique', $client) }}" class="px-4 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg text-sm">Reset</a>
        <a href="{{ route('clients.historique', array_merge(['client' => $client->id], request()->query())) }}&export=csv" class="ml-auto px-4 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
            ↓ Export CSV
        </a>
    </form>

    <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Plaque</th>
                    <th class="px-4 py-3 text-left">Référence</th>
                    <th class="px-4 py-3 text-left">Pièce</th>
                    <th class="px-4 py-3 text-left">Marque</th>
                    <th class="px-4 py-3 text-center">Qté</th>
                    <th class="px-4 py-3 text-right">Prix u.</th>
                    <th class="px-4 py-3 text-left">N° Commande</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-center">Payé</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1A1A1A]">
                @forelse($commandePieces as $cp)
                <tr class="hover:bg-[#1A1A1A] transition">
                    <td class="px-4 py-3 font-mono font-bold text-white">{{ $cp->commande->vehicule?->immatriculation ?? '—' }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-[#aaa]">{{ $cp->piece->reference }}</td>
                    <td class="px-4 py-3 text-white">{{ $cp->piece->nom }}</td>
                    <td class="px-4 py-3 text-[#aaa] text-xs">{{ $cp->piece->marque?->nom ?? '—' }}</td>
                    <td class="px-4 py-3 text-center text-white">{{ $cp->quantite }}</td>
                    <td class="px-4 py-3 text-right text-white">{{ number_format($cp->prix_unitaire, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-3"><a href="{{ route('commandes.show', $cp->commande) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $cp->commande->numero }}</a></td>
                    <td class="px-4 py-3 text-[#aaa] text-xs">{{ $cp->commande->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3"><x-badge-statut :statut="$cp->commande->statut" /></td>
                    <td class="px-4 py-3 text-center">
                        @if($cp->commande->statut_paiement === 'paye')
                            <svg class="w-4 h-4 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @elseif($cp->commande->statut_paiement === 'acompte')
                            <span class="inline-block w-2 h-2 rounded-full bg-orange-400"></span>
                        @else
                            <svg class="w-4 h-4 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('commandes.create', ['client_id' => $client->id, 'piece_id' => $cp->piece_id, 'vehicule_id' => $cp->commande->vehicule_id]) }}" class="text-xs px-2.5 py-1 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded transition">
                            Recommander
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="11" class="px-4 py-10 text-center text-[#555]">Aucune pièce commandée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $commandePieces->links() }}</div>
</div>
@endsection
