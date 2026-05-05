@extends('layouts.app')
@section('title', $client->nom_complet)
@section('header', $client->nom_complet)

@section('content')
<div class="pt-2 space-y-6">
    {{-- Header --}}
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 {{ $client->is_pro ? 'bg-orange-600/20 border border-orange-600/30' : 'bg-blue-600/20 border border-blue-600/30' }} rounded-xl flex items-center justify-center">
                @if($client->is_pro)
                    <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 00-1-1h-2a1 1 0 00-1 1v5m4 0H9"/></svg>
                @else
                    <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                @endif
            </div>
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-white text-xl font-bold">{{ $client->nom_complet }}</h2>
                    @if($client->is_pro)
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-orange-900/20 text-orange-400 border border-orange-400/20">PRO</span>
                        @if($client->remise_pct > 0)
                            <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-green-900/20 text-green-400 border border-green-400/20">Remise {{ $client->remise_pct }}%</span>
                        @endif
                    @else
                        <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-blue-900/20 text-blue-400 border border-blue-400/20">PARTICULIER</span>
                    @endif
                </div>
                <p class="text-[#666] text-sm mt-0.5">{{ $client->email }} — {{ $client->tel_mobile }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('commandes.create', ['client_id' => $client->id]) }}" class="px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">
                + Nouvelle commande
            </a>
            <a href="{{ route('clients.vehicules.create', $client) }}" class="px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
                + Véhicule
            </a>
            <a href="{{ route('clients.edit', $client) }}" class="px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
                Modifier
            </a>
        </div>
    </div>

    {{-- Summary stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
            <p class="text-[#E53935] text-2xl font-bold">{{ $client->vehicules->count() }}</p>
            <p class="text-[#666] text-xs mt-1">Véhicule(s)</p>
        </div>
        <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
            <p class="text-[#E53935] text-2xl font-bold">{{ $client->commandes->count() }}</p>
            <p class="text-[#666] text-xs mt-1">Commande(s)</p>
        </div>
        <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
            <p class="text-[#E53935] text-2xl font-bold">{{ $totalPieces }}</p>
            <p class="text-[#666] text-xs mt-1">Pièces commandées</p>
        </div>
        <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
            <p class="text-[#E53935] text-2xl font-bold">{{ number_format($totalDepense, 0, ',', ' ') }} €</p>
            <p class="text-[#666] text-xs mt-1">Total dépensé</p>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        {{-- Left: Info --}}
        <div class="space-y-4">
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold text-sm mb-4 uppercase tracking-wider text-[#aaa]">Informations</h3>
                <dl class="space-y-2.5 text-sm">
                    @if($client->is_pro)
                        <div class="flex justify-between"><dt class="text-[#666]">SIRET</dt><dd class="text-white font-mono text-xs">{{ $client->siret ?? '—' }}</dd></div>
                        <div class="flex justify-between"><dt class="text-[#666]">TVA intra</dt><dd class="text-white font-mono text-xs">{{ $client->tva_intra ?? '—' }}</dd></div>
                        <div class="flex justify-between"><dt class="text-[#666]">Conditions</dt><dd class="text-white">{{ str_replace('_', ' ', $client->conditions_reglement) }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-[#666]">Ville</dt><dd class="text-white">{{ $client->code_postal }} {{ $client->ville }}</dd></div>
                    @if($client->adresse)
                    <div class="flex justify-between"><dt class="text-[#666]">Adresse</dt><dd class="text-white text-right text-xs">{{ $client->adresse }}</dd></div>
                    @endif
                    <div class="flex justify-between"><dt class="text-[#666]">Source</dt><dd class="text-white">{{ $client->source ?? '—' }}</dd></div>
                    <div class="flex justify-between"><dt class="text-[#666]">Depuis</dt><dd class="text-white">{{ $client->created_at->format('d/m/Y') }}</dd></div>
                </dl>
            </div>

            @if($client->notes)
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold text-sm mb-3 uppercase tracking-wider text-[#aaa]">Notes internes</h3>
                <p class="text-[#aaa] text-sm">{{ $client->notes }}</p>
            </div>
            @endif

            {{-- Véhicules --}}
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider text-[#aaa]">Véhicules</h3>
                    <a href="{{ route('clients.vehicules.index', $client) }}" class="text-xs text-[#E53935] hover:underline">Tous →</a>
                </div>
                @foreach($client->vehicules as $v)
                <a href="{{ route('clients.vehicules.show', [$client, $v]) }}" class="flex items-center gap-3 py-2 border-b border-[#1A1A1A] last:border-0 hover:text-[#E53935] transition">
                    <svg class="w-4 h-4 text-[#555] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2M13 16l2 2m-2-2V8l3 3 3-3v8"/></svg>
                    <div>
                        <p class="text-white text-sm font-semibold font-mono">{{ $v->immatriculation }}</p>
                        <p class="text-[#666] text-xs">{{ $v->marque }} {{ $v->modele }} — {{ $v->annee }}</p>
                    </div>
                </a>
                @endforeach
                @if($client->vehicules->isEmpty())
                    <p class="text-[#555] text-sm">Aucun véhicule enregistré.</p>
                @endif
            </div>
        </div>

        {{-- Right: Commandes + Interactions --}}
        <div class="col-span-2 space-y-4">
            <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-[#222] flex items-center justify-between">
                    <h3 class="text-white font-semibold">Dernières commandes</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('clients.historique', $client) }}" class="text-xs text-[#E53935] hover:underline">Historique pièces</a>
                        <span class="text-[#333]">|</span>
                        <a href="{{ route('commandes.index', ['client_id' => $client->id]) }}" class="text-xs text-[#666] hover:text-white">Toutes →</a>
                    </div>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-[#1A1A1A] text-[#666] text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2.5 text-left">N°</th>
                            <th class="px-4 py-2.5 text-left">Date</th>
                            <th class="px-4 py-2.5 text-left">Statut</th>
                            <th class="px-4 py-2.5 text-left">Paiement</th>
                            <th class="px-4 py-2.5 text-right">Total TTC</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#1A1A1A]">
                        @forelse($client->commandes as $commande)
                        <tr class="hover:bg-[#1A1A1A] transition">
                            <td class="px-4 py-3"><a href="{{ route('commandes.show', $commande) }}" class="text-[#E53935] hover:underline font-mono text-xs">{{ $commande->numero }}</a></td>
                            <td class="px-4 py-3 text-[#aaa]">{{ $commande->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3"><x-badge-statut :statut="$commande->statut" /></td>
                            <td class="px-4 py-3"><x-badge-paiement :statut="$commande->statut_paiement" /></td>
                            <td class="px-4 py-3 text-right text-white font-semibold">{{ number_format($commande->total_ttc, 2, ',', ' ') }} €</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-[#555]">Aucune commande.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Interactions --}}
            <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
                <div class="px-5 py-4 border-b border-[#222] flex items-center justify-between">
                    <h3 class="text-white font-semibold">Dernières interactions</h3>
                    <a href="{{ route('clients.interactions.index', $client) }}" class="text-xs text-[#E53935] hover:underline">Voir tout →</a>
                </div>
                <div class="divide-y divide-[#1A1A1A]">
                    @forelse($client->interactions as $interaction)
                    <div class="px-5 py-3 flex items-start gap-3">
                        <div class="w-7 h-7 bg-[#1A1A1A] rounded-lg flex items-center justify-center mt-0.5 flex-shrink-0">
                            @php $icons = ['appel' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>', 'email' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'visite' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>', 'devis' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>', 'reclamation' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'];
                            $icon = $icons[$interaction->type] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>'; @endphp
                            <svg class="w-3.5 h-3.5 text-[#666]" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-white text-sm">{{ Str::limit($interaction->contenu, 100) }}</p>
                            <p class="text-[#555] text-xs mt-0.5">{{ $interaction->user->name }} — {{ $interaction->date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="px-5 py-4 text-[#555] text-sm">Aucune interaction enregistrée.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
