<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Segh Pièces Détachées</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#0D0D0D] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-sm px-4">
        <div class="mb-8 text-center">
            <div class="w-9 h-9 bg-[#C62828] rounded-lg flex items-center justify-center mx-auto mb-5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h1 class="text-white font-semibold text-lg">Segh Pièces Détachées</h1>
            <p class="text-white/30 text-sm mt-1">Connectez-vous à votre espace CRM</p>
        </div>

        <div class="bg-[#141414] border border-white/[0.07] rounded-xl p-6">
            @if($errors->any())
            <div class="bg-red-500/[0.08] border border-red-500/20 text-red-400 px-3 py-2.5 rounded-lg text-xs mb-5">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-white/40 text-xs font-medium mb-1.5">Adresse email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-[#1a1a1a] border border-white/[0.08] text-white text-sm rounded-lg px-3.5 py-2.5 focus:outline-none focus:border-white/20 placeholder-white/20 transition-colors"
                        placeholder="admin@segh.fr">
                </div>
                <div>
                    <label class="block text-white/40 text-xs font-medium mb-1.5">Mot de passe</label>
                    <input type="password" name="password" required
                        class="w-full bg-[#1a1a1a] border border-white/[0.08] text-white text-sm rounded-lg px-3.5 py-2.5 focus:outline-none focus:border-white/20 placeholder-white/20 transition-colors"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="remember" id="remember" class="w-3.5 h-3.5 rounded bg-[#1a1a1a] border-white/20 text-[#C62828]">
                    <label for="remember" class="text-white/35 text-xs">Rester connecté</label>
                </div>
                <button type="submit" class="w-full bg-[#C62828] hover:bg-[#b71c1c] text-white font-medium py-2.5 rounded-lg transition-colors text-sm mt-2">
                    Se connecter
                </button>
            </form>
        </div>
        <p class="text-center text-white/15 text-xs mt-6">Mouroux (77) — {{ date('Y') }}</p>
    </div>
</body>
</html>
