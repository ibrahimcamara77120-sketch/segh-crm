@extends('layouts.app')
@section('title', 'Vue d\'ensemble')
@section('header', 'Vue d\'ensemble')

@section('content')
<div class="space-y-6">

    {{-- KPIs --}}
    <div class="grid grid-cols-4 gap-4">
        @php
        $kpis = [
            ['label' => 'Total clients', 'value' => $stats['total_clients'], 'format' => 'number'],
            ['label' => 'Commandes ce mois', 'value' => $stats['commandes_mois'], 'format' => 'number'],
            ['label' => "Chiffre d'affaires", 'value' => $stats['ca_mois'], 'format' => 'currency'],
            ['label' => 'Impayés en cours', 'value' => $stats['total_impayes'], 'format' => 'currency', 'alert' => $stats['total_impayes'] > 0],
        ];
        @endphp
        @foreach($kpis as $kpi)
        <div class="card px-5 py-4">
            <p class="text-white/35 text-xs font-medium mb-2">{{ $kpi['label'] }}</p>
            <p class="text-white font-semibold text-2xl tracking-tight {{ isset($kpi['alert']) && $kpi['alert'] ? 'text-[#ef5350]' : '' }}">
                @if($kpi['format'] === 'currency')
                    {{ number_format($kpi['value'], 0, ',', ' ') }} €
                @else
                    {{ number_format($kpi['value']) }}
                @endif
            </p>
        </div>
        @endforeach
    </div>

    {{-- Sub stats --}}
    <div class="grid grid-cols-4 gap-4">
        <div class="card px-4 py-3.5 flex items-center justify-between">
            <div>
                <p class="text-white/30 text-xs mb-1">En attente</p>
                <p class="text-white font-semibold text-lg">{{ $stats['commandes_en_attente'] }}</p>
            </div>
            <div class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="card px-4 py-3.5 flex items-center justify-between">
            <div>
                <p class="text-white/30 text-xs mb-1">Livrées</p>
                <p class="text-white font-semibold text-lg">{{ $stats['commandes_traitees'] }}</p>
            </div>
            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
        <div class="card px-4 py-3.5 flex items-center justify-between">
            <div>
                <p class="text-white/30 text-xs mb-1">Pièces manquantes</p>
                <p class="text-white font-semibold text-lg">{{ $stats['commandes_pieces_manquantes'] }}</p>
            </div>
            <div class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-red-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="card px-4 py-3.5 flex items-center justify-between">
            <div>
                <p class="text-white/30 text-xs mb-1">RDV aujourd'hui</p>
                <p class="text-white font-semibold text-lg">{{ $stats['rdv_aujourd_hui'] }}</p>
            </div>
            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="card col-span-2 p-5">
            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-5">Commandes — 6 derniers mois</p>
            <canvas id="chartCommandes" height="90"></canvas>
        </div>
        <div class="card p-5">
            <p class="text-white/60 text-xs font-medium uppercase tracking-wider mb-5">Répartition paiements</p>
            <canvas id="chartPaiements" height="160"></canvas>
        </div>
    </div>

    {{-- Top pièces + RDV --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="card">
            <div class="px-5 py-4 border-b border-white/[0.05]">
                <p class="text-white/60 text-xs font-medium uppercase tracking-wider">Top 5 pièces vendues</p>
            </div>
            <div class="divide-y divide-white/[0.04]">
                @forelse($topPieces as $i => $cp)
                <div class="px-5 py-3 flex items-center gap-3">
                    <span class="text-white/20 text-xs font-mono w-4">{{ $i+1 }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-white/80 text-sm truncate">{{ $cp->piece->nom ?? '—' }}</p>
                        <p class="text-white/25 text-xs font-mono">{{ $cp->piece->reference ?? '' }}</p>
                    </div>
                    <span class="text-white/50 text-xs font-medium">{{ $cp->total_vendu }} u.</span>
                </div>
                @empty
                <p class="px-5 py-4 text-white/25 text-sm">Aucune donnée</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="px-5 py-4 border-b border-white/[0.05]">
                <p class="text-white/60 text-xs font-medium uppercase tracking-wider">Rendez-vous aujourd'hui</p>
            </div>
            @if($commandesRdvAujourdHui->isEmpty())
            <div class="px-5 py-8 text-center">
                <p class="text-white/25 text-sm">Aucun rendez-vous prévu</p>
            </div>
            @else
            <div class="divide-y divide-white/[0.04]">
                @foreach($commandesRdvAujourdHui as $cmd)
                <a href="{{ route('commandes.show', $cmd) }}" class="px-5 py-3 flex items-center gap-3 hover:bg-white/[0.02] transition-colors">
                    <div class="flex-1 min-w-0">
                        <p class="text-white/80 text-sm font-medium">{{ $cmd->client->nom_complet }}</p>
                        <p class="text-white/30 text-xs mt-0.5">{{ $cmd->numero }}@if($cmd->vehicule) — {{ $cmd->vehicule->immatriculation }}@endif</p>
                    </div>
                    <x-badge-statut :statut="$cmd->statut" />
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    @if($alertesStock > 0)
    <a href="{{ route('pieces.alertes') }}" class="flex items-center gap-3 card px-5 py-3.5 border-[#C62828]/20 hover:border-[#C62828]/40 transition-colors">
        <svg class="w-4 h-4 text-[#ef5350] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="text-[#ef5350]/80 text-sm">{{ $alertesStock }} pièce(s) en dessous du seuil d'alerte</p>
        <span class="ml-auto text-white/25 text-xs">Voir les alertes →</span>
    </a>
    @endif
</div>

<script>
Chart.defaults.color = 'rgba(255,255,255,0.3)';
Chart.defaults.borderColor = 'rgba(255,255,255,0.05)';
Chart.defaults.font.family = 'Inter';
Chart.defaults.font.size = 11;

new Chart(document.getElementById('chartCommandes'), {
    type: 'bar',
    data: {
        labels: @json($labelsMois),
        datasets: [{
            data: @json($commandesMois),
            backgroundColor: 'rgba(198,40,40,0.25)',
            borderColor: 'rgba(198,40,40,0.7)',
            borderWidth: 1,
            borderRadius: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false }, ticks: { color: 'rgba(255,255,255,0.25)' } },
            y: { grid: { color: 'rgba(255,255,255,0.04)' }, ticks: { color: 'rgba(255,255,255,0.25)', stepSize: 1 } }
        }
    }
});

new Chart(document.getElementById('chartPaiements'), {
    type: 'doughnut',
    data: {
        labels: @json(array_keys($repartitionPaiements)),
        datasets: [{
            data: @json(array_values($repartitionPaiements)),
            backgroundColor: ['rgba(16,185,129,0.7)', 'rgba(245,158,11,0.7)', 'rgba(239,68,68,0.7)', 'rgba(100,116,139,0.5)'],
            borderWidth: 0,
            hoverOffset: 4,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { color: 'rgba(255,255,255,0.4)', padding: 12, boxWidth: 8, boxHeight: 8, usePointStyle: true } }
        }
    }
});
</script>
@endsection
