<?php

namespace App\Http\Controllers;

use App\Models\{Piece, Marque, Categorie};
use Illuminate\Http\Request;

class PieceController extends Controller
{
    public function index(Request $request)
    {
        $query = Piece::with(['marque', 'categorie']);
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%$search%")->orWhere('reference', 'like', "%$search%");
            });
        }
        if ($request->categorie_id) $query->where('categorie_id', $request->categorie_id);
        if ($request->marque_id) $query->where('marque_id', $request->marque_id);
        if ($request->stock === 'alerte') $query->whereColumn('stock', '<=', 'seuil_alerte')->where('stock', '>', 0);
        if ($request->stock === 'rupture') $query->where('stock', '<=', 0);

        $pieces = $query->latest()->paginate(20)->withQueryString();
        $categories = Categorie::orderBy('nom')->get();
        $marques = Marque::orderBy('nom')->get();
        return view('pieces.index', compact('pieces', 'categories', 'marques'));
    }

    public function create()
    {
        $marques = Marque::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();
        return view('pieces.create', compact('marques', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|unique:pieces|string|max:100',
            'nom' => 'required|string|max:255',
            'prix_vente' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pieces', 'public');
        }
        Piece::create($data);
        return redirect()->route('pieces.index')->with('success', 'Pièce ajoutée.');
    }

    public function show(Piece $piece)
    {
        $piece->load('marque', 'categorie');
        return view('pieces.show', compact('piece'));
    }

    public function edit(Piece $piece)
    {
        $marques = Marque::orderBy('nom')->get();
        $categories = Categorie::orderBy('nom')->get();
        return view('pieces.edit', compact('piece', 'marques', 'categories'));
    }

    public function update(Request $request, Piece $piece)
    {
        $request->validate([
            'reference' => 'required|string|max:100|unique:pieces,reference,'.$piece->id,
            'nom' => 'required|string|max:255',
            'prix_vente' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('pieces', 'public');
        }
        $piece->update($data);
        return redirect()->route('pieces.show', $piece)->with('success', 'Pièce mise à jour.');
    }

    public function destroy(Piece $piece)
    {
        $piece->delete();
        return redirect()->route('pieces.index')->with('success', 'Pièce supprimée.');
    }

    public function stock(Piece $piece)
    {
        return response()->json([
            'stock' => $piece->stock,
            'seuil_alerte' => $piece->seuil_alerte,
            'status' => $piece->stock_status,
        ]);
    }

    public function alertesStock()
    {
        $pieces = Piece::whereColumn('stock', '<=', 'seuil_alerte')->with(['marque', 'categorie'])->orderBy('stock')->paginate(30);
        return view('pieces.alertes', compact('pieces'));
    }
}
