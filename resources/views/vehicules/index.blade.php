@extends('layouts.app')
@section('title', 'Véhicules — ' . $client->nom_complet)
@section('header', 'Véhicules de ' . $client->nom_complet)

@section('content')
<div class="pt-2 space-y-4">
    <div class="flex items-center justify-between">
        <a href="{{ route('clients.show', $client) }}" class="text-[#666] hover:text-white transition text-sm">← Retour client</a>
        <a href="{{ route('clients.vehicules.create', $client) }}" class="px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">+ Ajouter un véhicule</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($vehicules as $vehicule)
        <div class="bg-[#111] border border-[#222] rounded-xl p-5 hover:border-[#333] transition group">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-white font-bold text-lg font-mono">{{ $vehicule->immatriculation }}</p>
                    <p class="text-[#aaa] text-sm">{{ $vehicule->marque }} {{ $vehicule->modele }}</p>
                    @if($vehicule->version)<p class="text-[#555] text-xs">{{ $vehicule->version }}</p>@endif
                </div>
                <div class="w-10 h-10 bg-[#1A1A1A] rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-[#555]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2M13 16l2 2m-2-2V8l3 3 3-3v8"/></svg>
                </div>
            </div>
            <dl class="grid grid-cols-2 gap-x-4 gap-y-1.5 text-xs mb-4">
                <div><dt class="text-[#555]">Année</dt><dd class="text-[#aaa]">{{ $vehicule->annee ?? '—' }}</dd></div>
                <div><dt class="text-[#555]">Carburant</dt><dd class="text-[#aaa] capitalize">{{ $vehicule->carburant ?? '—' }}</dd></div>
                <div><dt class="text-[#555]">Kilométrage</dt><dd class="text-[#aaa]">{{ $vehicule->km ? number_format($vehicule->km, 0, ',', ' ') . ' km' : '—' }}</dd></div>
                <div><dt class="text-[#555]">Commandes</dt><dd class="text-[#aaa]">{{ $vehicule->commandes_count }}</dd></div>
            </dl>
            <div class="flex gap-2 pt-3 border-t border-[#1A1A1A]">
                <a href="{{ route('clients.vehicules.show', [$client, $vehicule]) }}" class="flex-1 text-center px-3 py-1.5 bg-[#1A1A1A] hover:bg-[#222] text-white rounded-lg text-xs transition">Voir</a>
                <a href="{{ route('clients.vehicules.edit', [$client, $vehicule]) }}" class="flex-1 text-center px-3 py-1.5 bg-[#1A1A1A] hover:bg-[#222] text-[#aaa] hover:text-white rounded-lg text-xs transition">Modifier</a>
                <form method="POST" action="{{ route('clients.vehicules.destroy', [$client, $vehicule]) }}" onsubmit="return confirm('Supprimer ce véhicule ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-red-900/20 hover:bg-red-900/40 text-red-500 rounded-lg text-xs transition">Suppr.</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-[#555]">Aucun véhicule enregistré.</div>
        @endforelse
    </div>
</div>
@endsection
