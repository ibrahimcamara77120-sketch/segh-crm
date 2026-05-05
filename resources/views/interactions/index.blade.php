@extends('layouts.app')
@section('title', 'Interactions — ' . $client->nom_complet)
@section('header', 'Interactions — ' . $client->nom_complet)

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex items-center gap-3">
        <a href="{{ route('clients.show', $client) }}" class="text-[#666] hover:text-white transition text-sm">← Retour client</a>
    </div>

    <div class="grid grid-cols-3 gap-5">
        <div class="col-span-2 space-y-3">
            @forelse($interactions as $interaction)
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 bg-[#1A1A1A] rounded-lg flex items-center justify-center flex-shrink-0">
                        @php $icons = ['appel' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>', 'email' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'visite' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>', 'devis' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>', 'reclamation' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>'];
                        $icon = $icons[$interaction->type] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>'; @endphp
                        <svg class="w-4 h-4 text-[#666]" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#1A1A1A] text-[#aaa] border border-[#333]">{{ $interaction->type_label }}</span>
                            @if($interaction->commande)
                                <a href="{{ route('commandes.show', $interaction->commande) }}" class="text-xs text-[#E53935] hover:underline font-mono">{{ $interaction->commande->numero }}</a>
                            @endif
                        </div>
                        <p class="text-white text-sm leading-relaxed">{{ $interaction->contenu }}</p>
                        <p class="text-[#555] text-xs mt-2">{{ $interaction->user->name }} — {{ $interaction->date->format('d/m/Y à H:i') }}</p>
                    </div>
                    <form method="POST" action="{{ route('clients.interactions.destroy', [$client, $interaction]) }}" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-[#444] hover:text-red-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-[#111] border border-[#222] rounded-xl p-8 text-center text-[#555]">Aucune interaction enregistrée.</div>
            @endforelse
            <div>{{ $interactions->links() }}</div>
        </div>

        <div>
            <div class="bg-[#111] border border-[#222] rounded-xl p-5">
                <h3 class="text-white font-semibold mb-4">Nouvelle interaction</h3>
                <form method="POST" action="{{ route('clients.interactions.store', $client) }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[#aaa] text-xs mb-1.5">Type *</label>
                        <select name="type" required class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                            <option value="appel">Appel</option>
                            <option value="email">Email</option>
                            <option value="visite">Visite</option>
                            <option value="devis">Devis</option>
                            <option value="reclamation">Réclamation</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#aaa] text-xs mb-1.5">Date *</label>
                        <input type="datetime-local" name="date" value="{{ now()->format('Y-m-d\TH:i') }}" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                    </div>
                    <div>
                        <label class="block text-[#aaa] text-xs mb-1.5">Commande liée</label>
                        <select name="commande_id" class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                            <option value="">— Aucune —</option>
                            @foreach($commandes as $cmd)
                                <option value="{{ $cmd->id }}">{{ $cmd->numero }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[#aaa] text-xs mb-1.5">Contenu *</label>
                        <textarea name="contenu" rows="4" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] resize-none placeholder-[#555]" placeholder="Résumé de l'échange..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
