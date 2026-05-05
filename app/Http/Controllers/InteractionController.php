<?php

namespace App\Http\Controllers;

use App\Models\{Client, Interaction};
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function index(Client $client)
    {
        $interactions = $client->interactions()->with(['user', 'commande'])->latest('date')->paginate(20);
        $commandes = $client->commandes()->latest()->get();
        return view('interactions.index', compact('client', 'interactions', 'commandes'));
    }

    public function store(Request $request, Client $client)
    {
        $request->validate([
            'type' => 'required|in:appel,email,visite,devis,reclamation',
            'contenu' => 'required|string',
            'date' => 'required|date',
        ]);
        $client->interactions()->create([
            'type' => $request->type,
            'contenu' => $request->contenu,
            'date' => $request->date,
            'commande_id' => $request->commande_id ?: null,
            'user_id' => auth()->id(),
        ]);
        return back()->with('success', 'Interaction enregistrée.');
    }

    public function destroy(Client $client, Interaction $interaction)
    {
        $interaction->delete();
        return back()->with('success', 'Interaction supprimée.');
    }
}
