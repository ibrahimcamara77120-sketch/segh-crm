@extends('layouts.app')
@section('title', 'Clients')
@section('header', 'Clients')

@section('content')
<div class="pt-2">
    {{-- Header actions --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-2">
            <a href="{{ route('clients.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('type') ? 'bg-[#E53935] text-white' : 'bg-[#1A1A1A] text-[#aaa] hover:bg-[#222]' }} transition">Tous</a>
            <a href="{{ route('clients.index', ['type' => 'particulier']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('type') === 'particulier' ? 'bg-blue-600 text-white' : 'bg-[#1A1A1A] text-[#aaa] hover:bg-[#222]' }} transition">Particuliers</a>
            <a href="{{ route('clients.index', ['type' => 'professionnel']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('type') === 'professionnel' ? 'bg-orange-600 text-white' : 'bg-[#1A1A1A] text-[#aaa] hover:bg-[#222]' }} transition">Professionnels</a>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('clients.create', ['type' => 'particulier']) }}" class="flex items-center gap-2 px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">
                + Particulier
            </a>
            <a href="{{ route('clients.create', ['type' => 'professionnel']) }}" class="flex items-center gap-2 px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">
                + Professionnel
            </a>
        </div>
    </div>

    {{-- Search / filters --}}
    <form method="GET" class="bg-[#111] border border-[#222] rounded-xl p-4 mb-6">
        <input type="hidden" name="type" value="{{ request('type') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..."
                class="bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]">
            <input type="text" name="ville" value="{{ request('ville') }}" placeholder="Filtrer par ville..."
                class="bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]">
            <div class="flex gap-2">
                <select name="statut_paiement" class="flex-1 bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                    <option value="">Tous statuts paiement</option>
                    <option value="non_paye" {{ request('statut_paiement') === 'non_paye' ? 'selected' : '' }}>Non payé</option>
                    <option value="acompte" {{ request('statut_paiement') === 'acompte' ? 'selected' : '' }}>Acompte</option>
                    <option value="paye" {{ request('statut_paiement') === 'paye' ? 'selected' : '' }}>Payé</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm transition">Filtrer</button>
                <a href="{{ route('clients.index') }}" class="px-4 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Reset</a>
            </div>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Type</th>
                    <th class="px-4 py-3 text-left">Contact</th>
                    <th class="px-4 py-3 text-left">Ville</th>
                    <th class="px-4 py-3 text-center">Cmdes</th>
                    <th class="px-4 py-3 text-right">CA total</th>
                    <th class="px-4 py-3 text-left">Dernière cmde</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1A1A1A]">
                @forelse($clients as $client)
                <tr class="hover:bg-[#1A1A1A] transition group">
                    <td class="px-4 py-3">
                        <a href="{{ route('clients.show', $client) }}" class="text-white font-medium hover:text-[#E53935] transition">
                            {{ $client->nom_complet }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        @if($client->type === 'particulier')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-blue-900/20 text-blue-400 border border-blue-400/20">Particulier</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-orange-900/20 text-orange-400 border border-orange-400/20">Pro</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-[#aaa]">
                        <div>{{ $client->email }}</div>
                        <div class="text-[#555] text-xs">{{ $client->tel_mobile }}</div>
                    </td>
                    <td class="px-4 py-3 text-[#aaa]">{{ $client->ville }}</td>
                    <td class="px-4 py-3 text-center text-white font-medium">{{ $client->commandes_count }}</td>
                    <td class="px-4 py-3 text-right text-[#E53935] font-semibold">
                        {{ number_format($client->commandes_sum_total_ttc ?? 0, 2, ',', ' ') }} €
                    </td>
                    <td class="px-4 py-3 text-[#aaa] text-xs">
                        @if($client->commandes->first())
                            {{ $client->commandes->first()->created_at->format('d/m/Y') }}
                            <x-badge-paiement :statut="$client->commandes->first()->statut_paiement" />
                        @else
                            <span class="text-[#555]">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('clients.show', $client) }}" class="text-[#666] hover:text-white transition" title="Voir">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('clients.edit', $client) }}" class="text-[#666] hover:text-blue-400 transition" title="Modifier">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Supprimer ce client ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#666] hover:text-red-400 transition" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-[#555]">Aucun client trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $clients->links() }}</div>
</div>
@endsection
