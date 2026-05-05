@extends('layouts.app')
@section('title', $piece->nom)
@section('header', $piece->nom)

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex items-center justify-between">
        <a href="{{ route('pieces.index') }}" class="text-[#666] hover:text-white transition text-sm">← Catalogue</a>
        <div class="flex gap-2">
            <a href="{{ route('pieces.edit', $piece) }}" class="px-4 py-2 bg-[#1A1A1A] border border-[#333] text-[#aaa] hover:text-white rounded-lg text-sm transition">Modifier</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-5">
        <div class="bg-[#111] border border-[#222] rounded-xl p-5 space-y-3">
            @if($piece->photo)
            <img src="{{ asset('storage/' . $piece->photo) }}" alt="{{ $piece->nom }}" class="w-full h-40 object-cover rounded-lg mb-4">
            @else
            <div class="w-full h-40 bg-[#1A1A1A] rounded-lg flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-[#333]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            @endif

            <div class="font-mono text-[#E53935] font-bold text-sm">{{ $piece->reference }}</div>
            <h2 class="text-white font-bold text-lg leading-tight">{{ $piece->nom }}</h2>
            @if($piece->description)<p class="text-[#aaa] text-sm">{{ $piece->description }}</p>@endif

            <div class="pt-3 border-t border-[#222] space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-[#555]">Marque</span><span class="text-white">{{ $piece->marque?->nom ?? '—' }}</span></div>
                @if($piece->categorie)
                <div class="flex justify-between"><span class="text-[#555]">Catégorie</span>
                    <span class="px-2 py-0.5 rounded text-xs font-medium" style="background-color: {{ $piece->categorie->couleur }}33; color: {{ $piece->categorie->couleur }}">{{ $piece->categorie->nom }}</span>
                </div>
                @endif
                @if($piece->compatibilite)<div class="flex justify-between"><span class="text-[#555]">Compatibilité</span><span class="text-white text-xs text-right">{{ $piece->compatibilite }}</span></div>@endif
            </div>
        </div>

        <div class="col-span-2 space-y-4">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
                    <p class="text-[#555] text-xs uppercase tracking-wider mb-1">Prix achat HT</p>
                    <p class="text-white text-xl font-bold">{{ number_format($piece->prix_achat, 2, ',', ' ') }} €</p>
                </div>
                <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
                    <p class="text-[#555] text-xs uppercase tracking-wider mb-1">Prix vente HT</p>
                    <p class="text-[#E53935] text-xl font-bold">{{ number_format($piece->prix_vente, 2, ',', ' ') }} €</p>
                    <p class="text-[#555] text-xs">TTC: {{ number_format($piece->prix_vente * 1.2, 2, ',', ' ') }} €</p>
                </div>
                <div class="bg-[#111] border border-[#222] rounded-xl p-4 text-center">
                    <p class="text-[#555] text-xs uppercase tracking-wider mb-1">Marge</p>
                    @php $marge = $piece->prix_vente - $piece->prix_achat; $margePct = $piece->prix_achat > 0 ? ($marge / $piece->prix_achat * 100) : 0; @endphp
                    <p class="text-green-400 text-xl font-bold">{{ number_format($marge, 2, ',', ' ') }} €</p>
                    <p class="text-[#555] text-xs">{{ number_format($margePct, 1) }}%</p>
                </div>
            </div>

            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-4">Stock</h3>
                @php $status = $piece->stock_status; @endphp
                <div class="flex items-center gap-4">
                    <div class="text-5xl font-bold {{ $status === 'ok' ? 'text-green-400' : ($status === 'alerte' ? 'text-orange-400' : 'text-red-400') }}">
                        {{ $piece->stock }}
                    </div>
                    <div>
                        <p class="text-[#aaa] text-sm">unités disponibles</p>
                        <p class="text-[#555] text-xs">Seuil d'alerte : {{ $piece->seuil_alerte }}</p>
                        @if($status === 'rupture')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-red-900/20 text-red-400 border border-red-400/20 mt-1"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Rupture de stock</span>
                        @elseif($status === 'alerte')
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-orange-900/20 text-orange-400 border border-orange-400/20 mt-1"><span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span> Stock faible</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] bg-green-900/20 text-green-400 border border-green-400/20 mt-1"><span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> En stock</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
