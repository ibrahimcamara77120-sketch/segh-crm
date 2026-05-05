@props(['statut'])
@php
$cfg = match($statut) {
    'non_paye'  => ['text' => 'Non payé',   'class' => 'text-red-400/80 bg-red-400/[0.08] border-red-400/20'],
    'acompte'   => ['text' => 'Acompte',    'class' => 'text-amber-400/80 bg-amber-400/[0.08] border-amber-400/20'],
    'paye'      => ['text' => 'Payé',       'class' => 'text-emerald-400/80 bg-emerald-400/[0.08] border-emerald-400/20'],
    'rembourse' => ['text' => 'Remboursé',  'class' => 'text-white/25 bg-white/[0.04] border-white/10'],
    default     => ['text' => $statut,      'class' => 'text-white/40 bg-white/[0.04] border-white/10'],
};
@endphp
<span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium border {{ $cfg['class'] }}">
    {{ $cfg['text'] }}
</span>
