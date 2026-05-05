@extends('layouts.app')
@section('title', $vehicule->immatriculation)
@section('header', $vehicule->immatriculation . ' — ' . $vehicule->marque . ' ' . $vehicule->modele)

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('clients.vehicules.index', $client) }}" class="text-[#666] hover:text-white transition text-sm">← {{ $client->nom_complet }}</a>
        <div class="flex gap-2">
            <a href="{{ route('commandes.create', ['client_id' => $client->id, 'vehicule_id' => $vehicule->id]) }}" class="px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">+ Commande</a>
            <a href="{{ route('clients.vehicules.edit', [$client, $vehicule]) }}" class="px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Modifier</a>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-1 bg-[#111] border border-[#222] rounded-xl p-5">
            <div class="w-16 h-16 bg-[#1A1A1A] rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[#555]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2M13 16l2 2m-2-2V8l3 3 3-3v8"/></svg>
            </div>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-[#555]">Plaque</dt><dd class="text-white font-mono font-bold">{{ $vehicule->immatriculation }}</dd></div>
                <div class="flex justify-between"><dt class="text-[#555]">Marque</dt><dd class="text-white">{{ $vehicule->marque }}</dd></div>
                <div class="flex justify-between"><dt class="text-[#555]">Modèle</dt><dd class="text-white">{{ $vehicule->modele }}</dd></div>
                @if($vehicule->version)<div class="flex justify-between"><dt class="text-[#555]">Version</dt><dd class="text-white text-xs">{{ $vehicule->version }}</dd></div>@endif
                <div class="flex justify-between"><dt class="text-[#555]">Année</dt><dd class="text-white">{{ $vehicule->annee ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-[#555]">Carburant</dt><dd class="text-white capitalize">{{ $vehicule->carburant ?? '—' }}</dd></div>
                <div class="flex justify-between"><dt class="text-[#555]">Kilométrage</dt><dd class="text-white">{{ $vehicule->km ? number_format($vehicule->km, 0, ',', ' ') . ' km' : '—' }}</dd></div>
                @if($vehicule->couleur)<div class="flex justify-between"><dt class="text-[#555]">Couleur</dt><dd class="text-white">{{ $vehicule->couleur }}</dd></div>@endif
                @if($vehicule->vin)<div class="flex justify-between"><dt class="text-[#555]">VIN</dt><dd class="text-white font-mono text-xs">{{ $vehicule->vin }}</dd></div>@endif
            </dl>
            @if($vehicule->notes_meca)
            <div class="mt-4 pt-4 border-t border-[#222]">
                <p class="text-[#555] text-xs uppercase tracking-wider mb-2">Notes meca</p>
                <p class="text-[#aaa] text-xs">{{ $vehicule->notes_meca }}</p>
            </div>
            @endif
        </div>

        <div class="col-span-3 bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-[#222]">
                <h3 class="text-white font-semibold">Historique des pièces commandées</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Référence</th>
                        <th class="px-4 py-2.5 text-left">Pièce</th>
                        <th class="px-4 py-2.5 text-center">Qté</th>
                        <th class="px-4 py-2.5 text-right">Prix u.</th>
                        <th class="px-4 py-2.5 text-left">N° Commande</th>
                        <th class="px-4 py-2.5 text-left">Date</th>
                        <th class="px-4 py-2.5 text-left">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @forelse($commandePieces as $cp)
                    <tr class="hover:bg-[#1A1A1A] transition">
                        <td class="px-4 py-2.5 font-mono text-xs text-[#aaa]">{{ $cp->piece->reference }}</td>
                        <td class="px-4 py-2.5 text-white">{{ $cp->piece->nom }}</td>
                        <td class="px-4 py-2.5 text-center text-white">{{ $cp->quantite }}</td>
                        <td class="px-4 py-2.5 text-right text-white">{{ number_format($cp->prix_unitaire, 2, ',', ' ') }} €</td>
                        <td class="px-4 py-2.5"><a href="{{ route('commandes.show', $cp->commande) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $cp->commande->numero }}</a></td>
                        <td class="px-4 py-2.5 text-[#aaa] text-xs">{{ $cp->commande->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2.5"><x-badge-statut :statut="$cp->commande->statut" /></td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-10 text-center text-[#555]">Aucune pièce commandée pour ce véhicule.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-4 py-3">{{ $commandePieces->links() }}</div>
        </div>
    </div>
</div>
@endsection
