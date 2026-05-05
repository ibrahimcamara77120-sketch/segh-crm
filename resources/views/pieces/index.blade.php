@extends('layouts.app')
@section('title', 'Catalogue pièces')
@section('header', 'Catalogue pièces')

@section('content')
<div class="pt-2">
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-2">
            <a href="{{ route('pieces.alertes') }}" class="flex items-center gap-2 px-4 py-2 bg-red-900/20 border border-red-800/40 text-red-400 rounded-lg text-sm hover:bg-red-900/30 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Alertes stock
            </a>
        </div>
        <a href="{{ route('pieces.create') }}" class="px-4 py-2 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm font-medium transition">+ Nouvelle pièce</a>
    </div>

    <form method="GET" class="bg-[#111] border border-[#222] rounded-xl p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Référence, nom..." class="bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]">
            <select name="categorie_id" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                @endforeach
            </select>
            <select name="marque_id" class="bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                <option value="">Toutes marques</option>
                @foreach($marques as $m)
                    <option value="{{ $m->id }}" {{ request('marque_id') == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <select name="stock" class="flex-1 bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                    <option value="">Tout stock</option>
                    <option value="alerte" {{ request('stock') === 'alerte' ? 'selected' : '' }}>En alerte</option>
                    <option value="rupture" {{ request('stock') === 'rupture' ? 'selected' : '' }}>Rupture</option>
                </select>
                <button type="submit" class="px-4 py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg text-sm transition">Filtrer</button>
                <a href="{{ route('pieces.index') }}" class="px-3 py-2.5 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Reset</a>
            </div>
        </div>
    </form>

    <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Référence</th>
                    <th class="px-4 py-3 text-left">Nom</th>
                    <th class="px-4 py-3 text-left">Marque</th>
                    <th class="px-4 py-3 text-left">Catégorie</th>
                    <th class="px-4 py-3 text-right">Prix vente HT</th>
                    <th class="px-4 py-3 text-center">Stock</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1A1A1A]">
                @forelse($pieces as $piece)
                <tr class="hover:bg-[#1A1A1A] transition group">
                    <td class="px-4 py-3 font-mono text-xs text-[#aaa]">{{ $piece->reference }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('pieces.show', $piece) }}" class="text-white font-medium hover:text-[#E53935] transition">{{ $piece->nom }}</a>
                    </td>
                    <td class="px-4 py-3 text-[#aaa]">{{ $piece->marque?->nom ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($piece->categorie)
                        <span class="px-2 py-0.5 rounded text-xs font-medium text-white" style="background-color: {{ $piece->categorie->couleur }}44; border: 1px solid {{ $piece->categorie->couleur }}66; color: {{ $piece->categorie->couleur }}">
                            {{ $piece->categorie->nom }}
                        </span>
                        @else
                        <span class="text-[#555]">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right text-white font-semibold">{{ number_format($piece->prix_vente, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-3 text-center">
                        @php $status = $piece->stock_status; @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                            {{ $status === 'ok' ? 'bg-green-900/30 text-green-400 border border-green-800' : ($status === 'alerte' ? 'bg-orange-900/30 text-orange-400 border border-orange-800' : 'bg-red-900/30 text-red-400 border border-red-800') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status === 'ok' ? 'bg-green-400' : ($status === 'alerte' ? 'bg-orange-400' : 'bg-red-400') }}"></span>
                            {{ $piece->stock }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('pieces.show', $piece) }}" class="text-[#666] hover:text-white transition text-xs">Voir</a>
                            <a href="{{ route('pieces.edit', $piece) }}" class="text-[#666] hover:text-blue-400 transition text-xs">Modifier</a>
                            <form method="POST" action="{{ route('pieces.destroy', $piece) }}" onsubmit="return confirm('Supprimer cette pièce ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#666] hover:text-red-400 transition text-xs">Suppr.</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-12 text-center text-[#555]">Aucune pièce trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pieces->links() }}</div>
</div>
@endsection
