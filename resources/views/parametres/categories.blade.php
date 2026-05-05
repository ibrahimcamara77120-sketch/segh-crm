@extends('layouts.app')
@section('title', 'Catégories')
@section('header', 'Gestion des catégories')

@section('content')
<div class="pt-2 grid grid-cols-3 gap-6">
    <div class="col-span-2">
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Catégorie</th>
                        <th class="px-4 py-3 text-left">Couleur</th>
                        <th class="px-4 py-3 text-center">Pièces</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-[#1A1A1A] transition">
                        <td class="px-4 py-3">
                            <span class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full flex-shrink-0" style="background: {{ $cat->couleur }}"></span>
                                <span class="text-white">{{ $cat->nom }}</span>
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-[#aaa]">{{ $cat->couleur }}</td>
                        <td class="px-4 py-3 text-center text-[#aaa]">{{ $cat->pieces_count }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('parametres.categories.destroy', $cat) }}" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#666] hover:text-red-400 transition text-xs">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-[#555]">Aucune catégorie.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $categories->links() }}</div>
    </div>

    <div class="bg-[#111] border border-[#222] rounded-xl p-5">
        <h3 class="text-white font-semibold mb-4">Nouvelle catégorie</h3>
        <form method="POST" action="{{ route('parametres.categories.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Nom *</label>
                <input type="text" name="nom" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Freins">
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Couleur *</label>
                <input type="color" name="couleur" value="#E53935" class="w-full h-10 bg-[#1A1A1A] border border-[#333] rounded-lg cursor-pointer">
            </div>
            <button type="submit" class="w-full py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Créer</button>
        </form>
    </div>
</div>
@endsection
