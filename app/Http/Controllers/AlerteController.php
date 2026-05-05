<?php

namespace App\Http\Controllers;

use App\Models\{Piece, Commande};
use Carbon\Carbon;

class AlerteController extends Controller
{
    public function index()
    {
        $piecesAlerte = Piece::whereColumn('stock', '<=', 'seuil_alerte')->with(['marque', 'categorie'])->orderBy('stock')->get();
        $commandesEnAttente = Commande::where('statut', 'en_attente')->where('created_at', '<=', Carbon::now()->subDays(3))->with('client')->get();
        $commandesImpayes = Commande::whereIn('statut_paiement', ['non_paye', 'acompte'])->whereNotIn('statut', ['annulee'])->where('created_at', '<=', Carbon::now()->subDays(7))->with('client')->get();
        $commandesPiecesManquantes = Commande::where('commande_incomplete', true)->whereNotIn('statut', ['livree', 'annulee'])->with(['client', 'commandePieces.piece'])->get();
        $rdvAujourdhui = Commande::whereDate('date_rdv', Carbon::today())->with('client', 'vehicule')->get();
        $commandesAcompte = Commande::where('statut_paiement', 'acompte')->whereNotIn('statut', ['annulee'])->with('client')->get();

        return view('alertes.index', compact(
            'piecesAlerte', 'commandesEnAttente', 'commandesImpayes',
            'commandesPiecesManquantes', 'rdvAujourdhui', 'commandesAcompte'
        ));
    }
}
