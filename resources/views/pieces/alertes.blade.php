@extends('layouts.app')
@section('title', 'Alertes stock')
@section('header', 'Alertes stock')

@section('content')
<div class="pt-2 space-y-4">
    <div class="bg-red-900/20 border border-red-800/40 rounded-xl p-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <p class="text-red-400 font-medium">{{ $pieces->total() }} pièce(s) en dessous du seuil d'alerte ou en rupture de stock.</p>
    </div>

    <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Référence</th>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Marque</th>
                    <th class="px-4 py-3 text-left">Catégorie</th>
                    <th class="px-4 py-3 text-center">Stock</th>
                    <th class="px-4 py-3 text-center">Seuil</th>
                    <th class="px-4 py-3 text-left">Statut</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1A1A1A]">
                @forelse($pieces as $piece)
                <tr class="hover:bg-[#1A1A1A] transition">
                    <td class="px-4 py-3 font-mono text-xs text-[#aaa]">{{ $piece->reference }}</td>
                    <td class="px-4 py-3 text-white font-medium">{{ $piece->nom }}</td>
                    <td class="px-4 py-3 text-[#aaa]">{{ $piece->marque?->nom ?? '—' }}</td>
                    <td class="px-4 py-3 text-[#aaa]">{{ $piece->categorie?->nom ?? '—' }}</td>
                    <td class="px-4 py-3 text-center font-bold {{ $piece->stock <= 0 ? 'text-red-400' : 'text-orange-400' }} text-lg">{{ $piece->stock }}</td>
                    <td class="px-4 py-3 text-center text-[#555]">{{ $piece->seuil_alerte }}</td>
                    <td class="px-4 py-3">
                        @if($piece->stock <= 0)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-red-900/20 text-red-400 border border-red-400/20"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Rupture</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-medium bg-orange-900/20 text-orange-400 border border-orange-400/20"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Stock faible</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('pieces.edit', $piece) }}" class="text-xs px-3 py-1.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg transition">Modifier stock</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-4 py-10 text-center text-[#555]">Aucune alerte stock.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $pieces->links() }}</div>
</div>
@endsection
