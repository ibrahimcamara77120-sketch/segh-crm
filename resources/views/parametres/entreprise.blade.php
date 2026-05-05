@extends('layouts.app')
@section('title', 'Informations entreprise')
@section('header', 'Informations entreprise')

@section('content')
<div class="max-w-xl pt-2">
    <div class="bg-[#111] border border-[#222] rounded-xl p-6 space-y-4">
        <div class="flex items-center gap-4 pb-4 border-b border-[#222]">
            <div class="w-14 h-14 bg-[#E53935] rounded-xl flex items-center justify-center text-2xl font-bold text-white">S</div>
            <div>
                <h2 class="text-white font-bold text-lg">Segh Pièces Détachées</h2>
                <p class="text-[#555] text-sm">Mouroux (77) — Secteur automobile</p>
            </div>
        </div>
        <dl class="space-y-3 text-sm">
            <div class="flex justify-between py-2 border-b border-[#1A1A1A]">
                <dt class="text-[#555]">Adresse</dt>
                <dd class="text-white">Mouroux, 77120, Seine-et-Marne</dd>
            </div>
            <div class="flex justify-between py-2 border-b border-[#1A1A1A]">
                <dt class="text-[#555]">Activité</dt>
                <dd class="text-white">Vente de pièces détachées automobiles</dd>
            </div>
            <div class="flex justify-between py-2 border-b border-[#1A1A1A]">
                <dt class="text-[#555]">TVA appliquée</dt>
                <dd class="text-white">20% (standard)</dd>
            </div>
            <div class="flex justify-between py-2">
                <dt class="text-[#555]">Version CRM</dt>
                <dd class="text-white">1.0.0</dd>
            </div>
        </dl>
        <p class="text-[#444] text-xs mt-4">La configuration avancée de l'entreprise sera disponible dans une prochaine version.</p>
    </div>
</div>
@endsection
