<?php

namespace App\Http\Controllers;

use App\Models\{Client, Commande, Piece};
use App\Models\CommandePiece;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $debutMois = Carbon::now()->startOfMonth();
        $finMois = Carbon::now()->endOfMonth();

        $stats = [
            'total_clients' => Client::count(),
            'commandes_mois' => Commande::whereBetween('created_at', [$debutMois, $finMois])->count(),
            'ca_mois' => Commande::whereBetween('created_at', [$debutMois, $finMois])->whereIn('statut', ['livree', 'prete'])->sum('total_ttc'),
            'commandes_en_attente' => Commande::where('statut', 'en_attente')->count(),
            'commandes_traitees' => Commande::whereIn('statut', ['livree', 'prete'])->count(),
            'commandes_annulees' => Commande::where('statut', 'annulee')->count(),
            'total_impayes' => Commande::whereIn('statut_paiement', ['non_paye', 'acompte'])->whereNotIn('statut', ['annulee'])->get()->sum('montant_restant'),
            'commandes_pieces_manquantes' => Commande::where('commande_incomplete', true)->whereNotIn('statut', ['livree', 'annulee'])->count(),
            'rdv_aujourd_hui' => Commande::whereDate('date_rdv', $today)->count(),
            'passages_aujourd_hui' => Commande::whereDate('date_passage', $today)->count(),
        ];

        $commandesMois = [];
        $labelsMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = Carbon::now()->subMonths($i);
            $labelsMois[] = $mois->format('M Y');
            $commandesMois[] = Commande::whereYear('created_at', $mois->year)->whereMonth('created_at', $mois->month)->count();
        }

        $topPieces = CommandePiece::selectRaw('piece_id, SUM(quantite) as total_vendu')
            ->groupBy('piece_id')->orderByDesc('total_vendu')->limit(5)
            ->with('piece')->get();

        $repartitionPaiements = [
            'Payé' => Commande::where('statut_paiement', 'paye')->count(),
            'Acompte' => Commande::where('statut_paiement', 'acompte')->count(),
            'Non payé' => Commande::where('statut_paiement', 'non_paye')->count(),
            'Remboursé' => Commande::where('statut_paiement', 'rembourse')->count(),
        ];

        $commandesRdvAujourdHui = Commande::whereDate('date_rdv', $today)->with('client', 'vehicule')->get();
        $alertesStock = Piece::whereColumn('stock', '<=', 'seuil_alerte')->count();

        return view('dashboard', compact('stats', 'commandesMois', 'labelsMois', 'topPieces', 'repartitionPaiements', 'commandesRdvAujourdHui', 'alertesStock'));
    }
}
