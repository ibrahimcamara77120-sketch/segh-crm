<?php

namespace App\Http\Controllers;

use App\Models\{Commande, Client, Piece, Vehicule, CommandePiece, Paiement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function index(Request $request)
    {
        $query = Commande::with(['client', 'vehicule']);
        if ($request->statut) $query->where('statut', $request->statut);
        if ($request->statut_paiement) $query->where('statut_paiement', $request->statut_paiement);
        if ($request->client_id) $query->where('client_id', $request->client_id);
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%$search%")
                  ->orWhereHas('client', function($cq) use ($search) {
                      $cq->where('nom', 'like', "%$search%")->orWhere('raison_sociale', 'like', "%$search%");
                  });
            });
        }
        if ($request->date_from) $query->whereDate('created_at', '>=', $request->date_from);
        if ($request->date_to) $query->whereDate('created_at', '<=', $request->date_to);

        $commandes = $query->latest()->paginate(20)->withQueryString();
        return view('commandes.index', compact('commandes'));
    }

    public function create(Request $request)
    {
        $clients = Client::orderBy('nom')->orderBy('raison_sociale')->get();
        $pieces = Piece::with(['marque', 'categorie'])->orderBy('nom')->get();
        $client = $request->client_id ? Client::with('vehicules')->find($request->client_id) : null;
        return view('commandes.create', compact('clients', 'pieces', 'client'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'pieces' => 'required|array|min:1',
            'pieces.*.piece_id' => 'required|exists:pieces,id',
            'pieces.*.quantite' => 'required|integer|min:1',
            'pieces.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($request) {
            $totalHt = 0;
            $incomplete = false;

            foreach ($request->pieces as $p) {
                $piece = Piece::find($p['piece_id']);
                $totalHt += $p['prix_unitaire'] * $p['quantite'];
                if ($piece->stock < $p['quantite']) $incomplete = true;
            }

            $tva = $totalHt * 0.20;
            $totalTtc = $totalHt + $tva;

            $client = Client::find($request->client_id);
            if ($client->type === 'professionnel' && $client->remise_pct > 0) {
                $remise = $totalTtc * ($client->remise_pct / 100);
                $totalTtc -= $remise;
                $tva = $totalTtc - $totalHt;
            }

            $commande = Commande::create([
                'numero' => Commande::genererNumero(),
                'client_id' => $request->client_id,
                'vehicule_id' => $request->vehicule_id ?: null,
                'statut' => 'en_attente',
                'statut_paiement' => 'non_paye',
                'total_ht' => $totalHt,
                'tva' => $tva,
                'total_ttc' => $totalTtc,
                'date_passage' => $request->date_passage ?: null,
                'date_rdv' => $request->date_rdv ?: null,
                'commande_incomplete' => $incomplete,
                'notes' => $request->notes,
            ]);

            foreach ($request->pieces as $p) {
                $piece = Piece::find($p['piece_id']);
                CommandePiece::create([
                    'commande_id' => $commande->id,
                    'piece_id' => $p['piece_id'],
                    'quantite' => $p['quantite'],
                    'prix_unitaire' => $p['prix_unitaire'],
                    'disponible_sur_place' => $piece->stock >= $p['quantite'],
                ]);
            }
        });

        return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès.');
    }

    public function show(Commande $commande)
    {
        $commande->load(['client', 'vehicule', 'commandePieces.piece.marque', 'paiements.user', 'interactions.user']);
        return view('commandes.show', compact('commande'));
    }

    public function edit(Commande $commande)
    {
        $clients = Client::orderBy('nom')->orderBy('raison_sociale')->get();
        $pieces = Piece::with(['marque', 'categorie'])->orderBy('nom')->get();
        $commande->load(['commandePieces.piece', 'client.vehicules']);
        return view('commandes.edit', compact('commande', 'clients', 'pieces'));
    }

    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'pieces' => 'required|array|min:1',
        ]);

        DB::transaction(function() use ($request, $commande) {
            $totalHt = 0;
            $incomplete = false;

            foreach ($request->pieces as $p) {
                $piece = Piece::find($p['piece_id']);
                $totalHt += $p['prix_unitaire'] * $p['quantite'];
                if ($piece->stock < $p['quantite']) $incomplete = true;
            }

            $tva = $totalHt * 0.20;
            $totalTtc = $totalHt + $tva;

            $commande->update([
                'client_id' => $request->client_id,
                'vehicule_id' => $request->vehicule_id ?: null,
                'total_ht' => $totalHt,
                'tva' => $tva,
                'total_ttc' => $totalTtc,
                'date_passage' => $request->date_passage ?: null,
                'date_rdv' => $request->date_rdv ?: null,
                'commande_incomplete' => $incomplete,
                'notes' => $request->notes,
            ]);

            $commande->commandePieces()->delete();
            foreach ($request->pieces as $p) {
                $piece = Piece::find($p['piece_id']);
                CommandePiece::create([
                    'commande_id' => $commande->id,
                    'piece_id' => $p['piece_id'],
                    'quantite' => $p['quantite'],
                    'prix_unitaire' => $p['prix_unitaire'],
                    'disponible_sur_place' => $piece->stock >= $p['quantite'],
                ]);
            }
        });

        return redirect()->route('commandes.show', $commande)->with('success', 'Commande mise à jour.');
    }

    public function updateStatut(Request $request, Commande $commande)
    {
        $request->validate(['statut' => 'required|in:en_attente,confirmee,en_preparation,prete,livree,annulee']);
        $ancienStatut = $commande->statut;
        $commande->update(['statut' => $request->statut]);

        if (in_array($request->statut, ['prete', 'livree']) && !in_array($ancienStatut, ['prete', 'livree'])) {
            foreach ($commande->commandePieces as $cp) {
                $cp->piece->decrement('stock', $cp->quantite);
            }
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    public function enregistrerPaiement(Request $request, Commande $commande)
    {
        $request->validate([
            'montant' => 'required|numeric|min:0.01',
            'mode' => 'required|in:especes,carte,virement,cheque',
            'date' => 'required|date',
        ]);

        Paiement::create([
            'commande_id' => $commande->id,
            'user_id' => auth()->id(),
            'montant' => $request->montant,
            'mode' => $request->mode,
            'reference' => $request->reference,
            'date' => $request->date,
            'notes' => $request->notes,
        ]);

        $totalPaye = $commande->paiements()->sum('montant');
        $statutPaiement = 'non_paye';
        if ($totalPaye >= $commande->total_ttc) $statutPaiement = 'paye';
        elseif ($totalPaye > 0) $statutPaiement = 'acompte';

        $commande->update([
            'montant_paye' => $totalPaye,
            'statut_paiement' => $statutPaiement,
            'mode_paiement' => $request->mode,
            'date_paiement' => $request->date,
        ]);

        return back()->with('success', 'Paiement enregistré.');
    }

    public function verifierStock(Commande $commande)
    {
        $pieces = $commande->commandePieces()->with('piece')->get()->map(function($cp) {
            return [
                'piece' => $cp->piece->nom,
                'reference' => $cp->piece->reference,
                'quantite_demandee' => $cp->quantite,
                'stock_disponible' => $cp->piece->stock,
                'status' => $cp->piece->stock >= $cp->quantite ? 'ok' : ($cp->piece->stock > 0 ? 'partiel' : 'rupture'),
            ];
        });
        return response()->json(['pieces' => $pieces, 'commande_incomplete' => $commande->commande_incomplete]);
    }

    public function pdf(Commande $commande)
    {
        $commande->load(['client', 'vehicule', 'commandePieces.piece.marque']);
        $type = in_array(request('type'), ['facture', 'devis']) ? request('type') : null;
        return view('commandes.pdf', compact('commande', 'type'));
    }
}
