<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $commande->numero }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111; background: white; }
        .header { display: flex; justify-content: space-between; padding: 20px; border-bottom: 3px solid #E53935; margin-bottom: 20px; }
        .company-name { font-size: 22px; font-weight: bold; color: #E53935; }
        .company-info { font-size: 10px; color: #666; margin-top: 4px; }
        .doc-title { text-align: right; }
        .doc-title h2 { font-size: 18px; color: #E53935; }
        .doc-title p { font-size: 11px; color: #666; }
        .section { margin: 16px 20px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .box { border: 1px solid #ddd; border-radius: 6px; padding: 12px; }
        .box h4 { font-size: 10px; text-transform: uppercase; letter-spacing: 0.05em; color: #666; margin-bottom: 8px; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f5f5f5; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; color: #666; border-bottom: 2px solid #E53935; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; }
        .total-row { background: #f9f9f9; font-weight: bold; }
        .grand-total { background: #E53935; color: white; font-size: 14px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: bold; }
        .badge-paye { background: #d4edda; color: #155724; }
        .badge-non_paye { background: #f8d7da; color: #721c24; }
        .footer { margin-top: 40px; padding: 12px 20px; border-top: 1px solid #eee; font-size: 10px; color: #999; text-align: center; }
        @media print { body { -webkit-print-color-adjust: exact; } }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div>
            <div class="company-name">Segh Pièces Détachées</div>
            <div class="company-info">Mouroux (77) — Vente de pièces automobiles<br>contact@segh.fr</div>
        </div>
        @php
            $docType = $type ?? (in_array($commande->statut, ['livree', 'prete']) ? 'facture' : 'devis');
            $isFacture = $docType === 'facture';
        @endphp
        <div class="doc-title">
            <h2>{{ $isFacture ? 'FACTURE' : 'DEVIS' }}</h2>
            <p>N° {{ $commande->numero }}</p>
            <p>Date : {{ now()->format('d/m/Y') }}</p>
            @if($isFacture)
                <span class="badge badge-{{ $commande->statut_paiement }}">{{ $commande->statut_paiement === 'paye' ? 'PAYÉ' : 'À RÉGLER' }}</span>
            @else
                <span class="badge" style="background:#fff3cd;color:#856404">DEVIS VALABLE 30 JOURS</span>
            @endif
        </div>
    </div>

    <div class="section grid-2">
        <div class="box">
            <h4>Client</h4>
            <p><strong>{{ $commande->client->nom_complet }}</strong></p>
            @if($commande->client->adresse)<p>{{ $commande->client->adresse }}</p>@endif
            @if($commande->client->code_postal)<p>{{ $commande->client->code_postal }} {{ $commande->client->ville }}</p>@endif
            @if($commande->client->email)<p>{{ $commande->client->email }}</p>@endif
            @if($commande->client->tel_mobile)<p>{{ $commande->client->tel_mobile }}</p>@endif
            @if($commande->client->is_pro && $commande->client->siret)<p style="font-size:10px;color:#666">SIRET : {{ $commande->client->siret }}</p>@endif
        </div>
        <div class="box">
            <h4>Détails</h4>
            @if($commande->vehicule)
            <p><strong>Véhicule :</strong> {{ $commande->vehicule->immatriculation }} — {{ $commande->vehicule->marque }} {{ $commande->vehicule->modele }}</p>
            @endif
            <p><strong>Statut :</strong> {{ $commande->statut_label }}</p>
            @if($commande->date_rdv)<p><strong>RDV :</strong> {{ $commande->date_rdv->format('d/m/Y') }}</p>@endif
        </div>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th style="width:15%">Référence</th>
                    <th>Désignation</th>
                    <th style="width:8%; text-align:center">Qté</th>
                    <th style="width:13%; text-align:right">Prix u. HT</th>
                    <th style="width:13%; text-align:right">Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commande->commandePieces as $cp)
                <tr>
                    <td style="font-family:monospace; font-size:10px; color:#666">{{ $cp->piece->reference }}</td>
                    <td>{{ $cp->piece->nom }}@if($cp->piece->marque) <span style="color:#999;font-size:10px">({{ $cp->piece->marque->nom }})</span>@endif</td>
                    <td style="text-align:center">{{ $cp->quantite }}</td>
                    <td style="text-align:right">{{ number_format($cp->prix_unitaire, 2, ',', ' ') }} €</td>
                    <td style="text-align:right">{{ number_format($cp->prix_unitaire * $cp->quantite, 2, ',', ' ') }} €</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row"><td colspan="4" style="text-align:right">Sous-total HT</td><td style="text-align:right">{{ number_format($commande->total_ht, 2, ',', ' ') }} €</td></tr>
                <tr class="total-row"><td colspan="4" style="text-align:right">TVA 20%</td><td style="text-align:right">{{ number_format($commande->tva, 2, ',', ' ') }} €</td></tr>
                <tr class="grand-total"><td colspan="4" style="text-align:right; padding: 10px">TOTAL TTC</td><td style="text-align:right; padding: 10px">{{ number_format($commande->total_ttc, 2, ',', ' ') }} €</td></tr>
                @if($commande->montant_paye > 0)
                <tr><td colspan="4" style="text-align:right; color:#155724">Déjà réglé</td><td style="text-align:right; color:#155724">- {{ number_format($commande->montant_paye, 2, ',', ' ') }} €</td></tr>
                <tr class="total-row"><td colspan="4" style="text-align:right">Reste dû</td><td style="text-align:right; color:#E53935; font-size:14px">{{ number_format($commande->montant_restant, 2, ',', ' ') }} €</td></tr>
                @endif
            </tfoot>
        </table>
    </div>

    @if($commande->notes)
    <div class="section"><div class="box"><h4>Notes</h4><p>{{ $commande->notes }}</p></div></div>
    @endif

    <div class="footer">Segh Pièces Détachées — Mouroux (77) — Document généré le {{ now()->format('d/m/Y à H:i') }}</div>
</body>
</html>
