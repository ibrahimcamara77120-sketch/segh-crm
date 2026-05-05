<?php

namespace App\Http\Controllers;

use App\Models\{Client, Vehicule};
use App\Models\CommandePiece;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index(Client $client)
    {
        $vehicules = $client->vehicules()->withCount('commandes')->latest()->get();
        return view('vehicules.index', compact('client', 'vehicules'));
    }

    public function create(Client $client)
    {
        return view('vehicules.create', compact('client'));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'immatriculation' => 'required|string|max:10',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:100',
            'vin' => 'nullable|string|max:17',
        ]);
        $vehicule = $client->vehicules()->create($request->all());
        return redirect()->route('clients.vehicules.show', [$client, $vehicule])->with('success', 'Véhicule ajouté.');
    }

    public function show(Client $client, Vehicule $vehicule)
    {
        $commandePieces = CommandePiece::whereHas('commande', function($q) use ($vehicule) {
            $q->where('vehicule_id', $vehicule->id);
        })->with(['piece.marque', 'piece.categorie', 'commande'])->latest()->paginate(20);
        return view('vehicules.show', compact('client', 'vehicule', 'commandePieces'));
    }

    public function edit(Client $client, Vehicule $vehicule)
    {
        return view('vehicules.edit', compact('client', 'vehicule'));
    }

    public function update(Request $request, Client $client, Vehicule $vehicule)
    {
        $request->validate([
            'immatriculation' => 'required|string|max:10',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:100',
        ]);
        $vehicule->update($request->all());
        return redirect()->route('clients.vehicules.show', [$client, $vehicule])->with('success', 'Véhicule mis à jour.');
    }

    public function destroy(Client $client, Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('clients.vehicules.index', $client)->with('success', 'Véhicule supprimé.');
    }
}
