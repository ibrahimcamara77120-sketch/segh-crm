@props(['statut'])
@php
$cfg = match($statut) {
    'en_attente'    => ['text' => 'En attente',    'class' => 'text-amber-400/80 bg-amber-400/[0.08] border-amber-400/20'],
    'confirmee'     => ['text' => 'Confirmée',     'class' => 'text-blue-400/80 bg-blue-400/[0.08] border-blue-400/20'],
    'en_preparation'=> ['text' => 'En préparation','class' => 'text-violet-400/80 bg-violet-400/[0.08] border-violet-400/20'],
    'prete'         => ['text' => 'Prête',         'class' => 'text-orange-400/80 bg-orange-400/[0.08] border-orange-400/20'],
    'livree'        => ['text' => 'Livrée',        'class' => 'text-emerald-400/80 bg-emerald-400/[0.08] border-emerald-400/20'],
    'annulee'       => ['text' => 'Annulée',       'class' => 'text-white/25 bg-white/[0.04] border-white/10'],
    default         => ['text' => $statut,         'class' => 'text-white/40 bg-white/[0.04] border-white/10'],
};
@endphp
<span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $cfg['class'] }}">
    {{ $cfg['text'] }}
</span>
