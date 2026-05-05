@extends('layouts.app')
@section('title', 'Utilisateurs')
@section('header', 'Gestion des utilisateurs')

@section('content')
<div class="pt-2 grid grid-cols-3 gap-6">
    <div class="col-span-2">
        <div class="bg-[#111] border border-[#222] rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-[#1A1A1A] text-[#666] uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">Nom</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Rôle</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1A1A1A]">
                    @foreach($users as $user)
                    <tr class="hover:bg-[#1A1A1A] transition">
                        <td class="px-4 py-3 text-white font-medium">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-[#E53935] rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                {{ $user->name }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-[#aaa]">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $user->role === 'admin' ? 'bg-red-900/30 text-red-400 border border-red-800' :
                                   ($user->role === 'commercial' ? 'bg-blue-900/30 text-blue-400 border border-blue-800' :
                                   'bg-green-900/30 text-green-400 border border-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('parametres.utilisateurs.destroy', $user) }}" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[#666] hover:text-red-400 transition text-xs">Supprimer</button>
                            </form>
                            @else
                            <span class="text-[#444] text-xs italic">Vous</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $users->links() }}</div>
    </div>

    <div class="bg-[#111] border border-[#222] rounded-xl p-5">
        <h3 class="text-white font-semibold mb-4">Nouvel utilisateur</h3>
        <form method="POST" action="{{ route('parametres.utilisateurs.store') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Nom *</label>
                <input type="text" name="name" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="Jean Dupont">
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Email *</label>
                <input type="email" name="email" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935] placeholder-[#555]" placeholder="jean@segh.fr">
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Rôle *</label>
                <select name="role" required class="w-full bg-[#1A1A1A] border border-[#333] text-[#aaa] rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
                    <option value="commercial">Commercial</option>
                    <option value="technicien">Technicien</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Mot de passe *</label>
                <input type="password" name="password" required minlength="8" class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
            </div>
            <div>
                <label class="block text-[#aaa] text-xs mb-1.5">Confirmer *</label>
                <input type="password" name="password_confirmation" required class="w-full bg-[#1A1A1A] border border-[#333] text-white rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-[#E53935]">
            </div>
            <button type="submit" class="w-full py-2.5 bg-[#E53935] hover:bg-[#c62828] text-white rounded-lg font-medium text-sm transition">Créer l'utilisateur</button>
        </form>
    </div>
</div>
@endsection
