@extends('layouts.app')
@section('title', 'Alertes')
@section('header', "Centre d'alertes")

@section('content')
<div class="pt-2 space-y-6">

    @if($rdvAujourdhui->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Rendez-vous aujourd'hui
            <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded">{{ $rdvAujourdhui->count() }}</span>
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($rdvAujourdhui as $cmd)
            <a href="{{ route('commandes.show', $cmd) }}" class="bg-[#111] border border-blue-900/50 rounded-xl p-4 flex items-center gap-3 hover:border-blue-700 transition">
                <div class="w-9 h-9 bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="text-white font-medium text-sm">{{ $cmd->client->nom_complet }}</p>
                    <p class="text-[#555] text-xs">{{ $cmd->numero }} — {{ $cmd->vehicule?->immatriculation ?? '—' }}</p>
                </div>
                <x-badge-statut :statut="$cmd->statut" />
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($piecesAlerte->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Stock en alerte
            <span class="bg-red-700 text-white text-xs px-2 py-0.5 rounded">{{ $piecesAlerte->count() }}</span>
        </h3>
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Référence</th>
                        <th class="px-4 py-2.5 text-left">Pièce</th>
                        <th class="px-4 py-2.5 text-center">Stock</th>
                        <th class="px-4 py-2.5 text-center">Seuil</th>
                        <th class="px-4 py-2.5 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @foreach($piecesAlerte as $p)
                    <tr class="hover:bg-[#1A1A1A]">
                        <td class="px-4 py-2.5 font-mono text-xs text-[#aaa]">{{ $p->reference }}</td>
                        <td class="px-4 py-2.5 text-white">{{ $p->nom }}</td>
                        <td class="px-4 py-2.5 text-center font-bold {{ $p->stock <= 0 ? 'text-red-400' : 'text-orange-400' }}">{{ $p->stock }}</td>
                        <td class="px-4 py-2.5 text-center text-[#555]">{{ $p->seuil_alerte }}</td>
                        <td class="px-4 py-2.5"><a href="{{ route('pieces.edit', $p) }}" class="text-xs text-[#E53935] hover:underline">Gérer stock →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($commandesImpayes->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Impayés à relancer
            <span class="bg-red-700 text-white text-xs px-2 py-0.5 rounded">{{ $commandesImpayes->count() }}</span>
        </h3>
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Commande</th>
                        <th class="px-4 py-2.5 text-left">Client</th>
                        <th class="px-4 py-2.5 text-left">Paiement</th>
                        <th class="px-4 py-2.5 text-right">Reste dû</th>
                        <th class="px-4 py-2.5 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @foreach($commandesImpayes as $cmd)
                    <tr class="hover:bg-[#1A1A1A]">
                        <td class="px-4 py-2.5"><a href="{{ route('commandes.show', $cmd) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $cmd->numero }}</a></td>
                        <td class="px-4 py-2.5 text-white">{{ $cmd->client->nom_complet }}</td>
                        <td class="px-4 py-2.5"><x-badge-paiement :statut="$cmd->statut_paiement" /></td>
                        <td class="px-4 py-2.5 text-right font-bold text-[#E53935]">{{ number_format($cmd->montant_restant, 2, ',', ' ') }} €</td>
                        <td class="px-4 py-2.5 text-[#aaa] text-xs">{{ $cmd->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($commandesEnAttente->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            En attente depuis +3 jours
            <span class="bg-yellow-700 text-white text-xs px-2 py-0.5 rounded">{{ $commandesEnAttente->count() }}</span>
        </h3>
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Commande</th>
                        <th class="px-4 py-2.5 text-left">Client</th>
                        <th class="px-4 py-2.5 text-left">Date</th>
                        <th class="px-4 py-2.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @foreach($commandesEnAttente as $cmd)
                    <tr class="hover:bg-[#1A1A1A]">
                        <td class="px-4 py-2.5"><a href="{{ route('commandes.show', $cmd) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $cmd->numero }}</a></td>
                        <td class="px-4 py-2.5 text-white">{{ $cmd->client->nom_complet }}</td>
                        <td class="px-4 py-2.5 text-[#aaa] text-xs">{{ $cmd->created_at->format('d/m/Y') }} ({{ $cmd->created_at->diffForHumans() }})</td>
                        <td class="px-4 py-2.5 text-right text-white font-semibold">{{ number_format($cmd->total_ttc, 2, ',', ' ') }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($commandesPiecesManquantes->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Pièces manquantes
            <span class="bg-orange-700 text-white text-xs px-2 py-0.5 rounded">{{ $commandesPiecesManquantes->count() }}</span>
        </h3>
        <div class="space-y-2">
            @foreach($commandesPiecesManquantes as $cmd)
            <div class="bg-[#111] border border-orange-900/40 rounded-xl p-4">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('commandes.show', $cmd) }}" class="text-[#E53935] font-mono text-sm hover:underline">{{ $cmd->numero }}</a>
                        <span class="text-white text-sm">— {{ $cmd->client->nom_complet }}</span>
                    </div>
                    <x-badge-statut :statut="$cmd->statut" />
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($cmd->commandePieces->where('disponible_sur_place', false) as $cp)
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-red-900/20 text-red-400 border border-red-400/20 rounded text-xs">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        {{ $cp->piece->nom }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($commandesAcompte->count())
    <div>
        <h3 class="text-white font-semibold mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Solde restant à encaisser
            <span class="bg-orange-600 text-white text-xs px-2 py-0.5 rounded">{{ $commandesAcompte->count() }}</span>
        </h3>
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Commande</th>
                        <th class="px-4 py-2.5 text-left">Client</th>
                        <th class="px-4 py-2.5 text-right">Total TTC</th>
                        <th class="px-4 py-2.5 text-right">Acompte versé</th>
                        <th class="px-4 py-2.5 text-right">Reste dû</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @foreach($commandesAcompte as $cmd)
                    <tr class="hover:bg-[#1A1A1A]">
                        <td class="px-4 py-2.5"><a href="{{ route('commandes.show', $cmd) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $cmd->numero }}</a></td>
                        <td class="px-4 py-2.5 text-white">{{ $cmd->client->nom_complet }}</td>
                        <td class="px-4 py-2.5 text-right text-white">{{ number_format($cmd->total_ttc, 2, ',', ' ') }} €</td>
                        <td class="px-4 py-2.5 text-right text-green-400">{{ number_format($cmd->montant_paye, 2, ',', ' ') }} €</td>
                        <td class="px-4 py-2.5 text-right font-bold text-orange-400">{{ number_format($cmd->montant_restant, 2, ',', ' ') }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if(!$rdvAujourdhui->count() && !$piecesAlerte->count() && !$commandesImpayes->count() && !$commandesEnAttente->count() && !$commandesPiecesManquantes->count() && !$commandesAcompte->count())
    <div class="text-center py-20">
        <div class="w-16 h-16 bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p class="text-white font-semibold text-lg">Tout est en ordre</p>
        <p class="text-[#555] text-sm mt-1">Aucune alerte active en ce moment.</p>
    </div>
    @endif
</div>
@endsection
