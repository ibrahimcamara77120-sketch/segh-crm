<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CRM') — Segh Pièces Détachées</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #2a2a2a; border-radius: 4px; }
        .nav-link { @apply flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-all duration-100; }
        .nav-link.active { background: rgba(255,255,255,0.07); color: white; }
        .nav-link:not(.active) { color: rgba(255,255,255,0.38); }
        .nav-link:not(.active):hover { background: rgba(255,255,255,0.04); color: rgba(255,255,255,0.75); }
        .btn-primary { @apply inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#C62828] hover:bg-[#b71c1c] text-white text-xs font-medium rounded-md transition-colors; }
        .btn-secondary { @apply inline-flex items-center gap-1.5 px-3.5 py-2 bg-white/[0.06] hover:bg-white/[0.09] text-white/70 hover:text-white text-xs font-medium rounded-md border border-white/[0.08] transition-colors; }
        .card { @apply bg-[#141414] border border-white/[0.06] rounded-xl; }
        .input { @apply w-full bg-[#1a1a1a] border border-white/[0.08] text-white text-sm rounded-lg px-3.5 py-2.5 focus:outline-none focus:border-white/20 placeholder-white/20 transition-colors; }
        .label { @apply block text-white/50 text-xs font-medium mb-1.5; }
        table.crm-table { @apply w-full text-sm; }
        table.crm-table thead tr { @apply border-b border-white/[0.06]; }
        table.crm-table thead th { @apply px-4 py-3 text-left text-xs font-medium text-white/30 uppercase tracking-wider; }
        table.crm-table tbody tr { @apply border-b border-white/[0.03] hover:bg-white/[0.02] transition-colors; }
        table.crm-table tbody td { @apply px-4 py-3 text-white/70; }
    </style>
</head>
<body class="h-full bg-[#0D0D0D] text-white antialiased" x-data="{}">
<div class="flex h-full min-h-screen">

    <aside class="w-52 bg-[#0D0D0D] border-r border-white/[0.05] flex flex-col fixed h-full z-20 overflow-hidden">
        <div class="px-4 py-4 border-b border-white/[0.05]">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-[#C62828] rounded flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a9 9 0 110 18A9 9 0 0112 2zm0 2a7 7 0 100 14A7 7 0 0012 4zm0 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm-3 5.5h6v1H9v-1z"/></svg>
                </div>
                <div>
                    <p class="text-white text-xs font-semibold leading-none">Segh Pièces</p>
                    <p class="text-white/25 text-[10px] mt-0.5">CRM v1.0</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-2.5 py-3 space-y-0.5 overflow-y-auto">
            @php
                $nbAlertes = \App\Models\Piece::whereColumn('stock', '<=', 'seuil_alerte')->count()
                           + \App\Models\Commande::whereIn('statut_paiement', ['non_paye','acompte'])->whereNotIn('statut', ['annulee'])->where('created_at', '<=', \Carbon\Carbon::now()->subDays(7))->count();
            @endphp

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="1.5"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="1.5"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="1.5"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="1.5"/></svg>
                Vue d'ensemble
            </a>

            <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Clients
            </a>

            <a href="{{ route('commandes.index') }}" class="nav-link {{ request()->routeIs('commandes.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Commandes
            </a>

            <a href="{{ route('pieces.index') }}" class="nav-link {{ request()->routeIs('pieces.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Catalogue
            </a>

            <a href="{{ route('alertes.index') }}" class="nav-link {{ request()->routeIs('alertes.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Alertes
                @if($nbAlertes > 0)
                <span class="ml-auto text-[10px] font-semibold bg-[#C62828]/20 text-[#ef5350] border border-[#C62828]/30 px-1.5 py-0.5 rounded-full">{{ $nbAlertes }}</span>
                @endif
            </a>

            @if(auth()->user()->isAdmin())
            <div class="pt-3 pb-1">
                <p class="px-2.5 text-[9px] font-semibold text-white/20 uppercase tracking-widest">Administration</p>
            </div>
            <a href="{{ route('parametres.utilisateurs') }}" class="nav-link {{ request()->routeIs('parametres.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Paramètres
            </a>
            @endif
        </nav>

        <div class="border-t border-white/[0.05] px-3.5 py-3">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-full bg-[#C62828]/80 flex items-center justify-center text-white text-[11px] font-semibold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white/80 text-xs font-medium truncate">{{ auth()->user()->name }}</p>
                    <p class="text-white/25 text-[10px] capitalize">{{ auth()->user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Déconnexion" class="text-white/20 hover:text-white/50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="ml-52 flex-1 flex flex-col min-h-screen">
        <header class="sticky top-0 z-10 bg-[#0D0D0D]/90 backdrop-blur-md border-b border-white/[0.05] px-7 h-12 flex items-center justify-between">
            <h1 class="text-white/70 text-sm font-medium">@yield('header', 'Vue d\'ensemble')</h1>
            <span class="text-white/20 text-xs">{{ now()->format('d M Y') }}</span>
        </header>

        @if(session('success') || session('error') || $errors->any())
        <div class="px-7 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-2.5 bg-emerald-500/[0.08] border border-emerald-500/20 text-emerald-400/90 px-4 py-2.5 rounded-lg text-xs mb-2" x-data="{s:true}" x-show="s">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
                <button @click="s=false" class="ml-auto opacity-50 hover:opacity-100"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-2.5 bg-red-500/[0.08] border border-red-500/20 text-red-400/90 px-4 py-2.5 rounded-lg text-xs mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @if($errors->any())
            <div class="bg-red-500/[0.08] border border-red-500/20 text-red-400/90 px-4 py-2.5 rounded-lg text-xs mb-2 space-y-0.5">
                @foreach($errors->all() as $e)<div>— {{ $e }}</div>@endforeach
            </div>
            @endif
        </div>
        @endif

        <main class="flex-1 px-7 py-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
