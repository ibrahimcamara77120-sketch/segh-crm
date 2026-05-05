<?php

namespace App\Http\Controllers;

use App\Models\{Client, Commande};
use App\Models\CommandePiece;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::withCount('commandes')
            ->withSum(['commandes' => function($q) {
                $q->whereIn('statut', ['livree', 'prete']);
            }], 'total_ttc')
            ->with(['commandes' => function($q) { $q->latest()->limit(1); }]);

        if ($request->type) $query->where('type', $request->type);
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                  ->orWhere('prenom', 'like', "%$search%")
                  ->orWhere('raison_sociale', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('tel_mobile', 'like', "%$search%");
            });
        }
        if ($request->ville) $query->where('ville', 'like', "%{$request->ville}%");
        if ($request->statut_paiement) {
            $query->whereHas('commandes', function($q) use ($request) {
                $q->where('statut_paiement', $request->statut_paiement);
            });
        }

        $clients = $query->latest()->paginate(20)->withQueryString();
        return view('clients.index', compact('clients'));
    }

    public function create(Request $request)
    {
        $type = $request->type ?? 'particulier';
        return view('clients.create', compact('type'));
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => 'required|in:particulier,professionnel',
            'email' => 'nullable|email',
            'siret' => 'nullable|digits:14',
        ];
        if ($request->type === 'particulier') {
            $rules['nom'] = 'required|string|max:255';
        } else {
            $rules['raison_sociale'] = 'required|string|max:255';
        }
        $request->validate($rules);
        $client = Client::create($request->all());
        return redirect()->route('clients.show', $client)->with('success', 'Client créé avec succès.');
    }

    public function show(Client $client)
    {
        $client->load(['vehicules', 'commandes' => function($q) { $q->latest()->limit(10); }, 'interactions' => function($q) { $q->latest()->limit(5); }]);
        $totalDepense = $client->commandes()->whereIn('statut', ['livree', 'prete'])->sum('total_ttc');
        $totalPieces = CommandePiece::whereHas('commande', function($q) use ($client) {
            $q->where('client_id', $client->id);
        })->sum('quantite');
        return view('clients.show', compact('client', 'totalDepense', 'totalPieces'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate(['email' => 'nullable|email', 'siret' => 'nullable|digits:14']);
        $client->update($request->all());
        return redirect()->route('clients.show', $client)->with('success', 'Client mis à jour.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé.');
    }

    public function historique(Client $client)
    {
        $client->load('vehicules');
        $vehiculeFiltreId = request('vehicule_id');

        $query = CommandePiece::whereHas('commande', function($q) use ($client) {
            $q->where('client_id', $client->id);
        })->with(['piece.marque', 'piece.categorie', 'commande.vehicule']);

        if ($vehiculeFiltreId) {
            $query->whereHas('commande', function($q) use ($vehiculeFiltreId) {
                $q->where('vehicule_id', $vehiculeFiltreId);
            });
        }

        $commandePieces = $query->latest()->paginate(30);
        return view('clients.historique', compact('client', 'commandePieces'));
    }
}
