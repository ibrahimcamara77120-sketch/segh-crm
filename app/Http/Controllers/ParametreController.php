<?php

namespace App\Http\Controllers;

use App\Models\{User, Categorie, Marque};
use Illuminate\Http\Request;

class ParametreController extends Controller
{
    public function utilisateurs()
    {
        $users = User::orderBy('name')->paginate(20);
        return view('parametres.utilisateurs', compact('users'));
    }

    public function storeUtilisateur(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,commercial,technicien',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        return back()->with('success', 'Utilisateur créé.');
    }

    public function updateUtilisateur(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,commercial,technicien']);
        $user->update($request->only('name', 'role'));
        return back()->with('success', 'Utilisateur mis à jour.');
    }

    public function destroyUtilisateur(User $user)
    {
        if ($user->id === auth()->id()) return back()->with('error', 'Impossible de supprimer votre propre compte.');
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function categories()
    {
        $categories = Categorie::withCount('pieces')->orderBy('nom')->paginate(20);
        return view('parametres.categories', compact('categories'));
    }

    public function storeCategorie(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100', 'couleur' => 'required|string']);
        Categorie::create($request->only('nom', 'couleur'));
        return back()->with('success', 'Catégorie créée.');
    }

    public function updateCategorie(Request $request, Categorie $categorie)
    {
        $request->validate(['nom' => 'required|string|max:100']);
        $categorie->update($request->only('nom', 'couleur'));
        return back()->with('success', 'Catégorie mise à jour.');
    }

    public function destroyCategorie(Categorie $categorie)
    {
        $categorie->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    public function marques()
    {
        $marques = Marque::withCount('pieces')->orderBy('nom')->paginate(20);
        return view('parametres.marques', compact('marques'));
    }

    public function storeMarque(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100']);
        Marque::create($request->only('nom'));
        return back()->with('success', 'Marque créée.');
    }

    public function updateMarque(Request $request, Marque $marque)
    {
        $request->validate(['nom' => 'required|string|max:100']);
        $marque->update($request->only('nom'));
        return back()->with('success', 'Marque mise à jour.');
    }

    public function destroyMarque(Marque $marque)
    {
        $marque->delete();
        return back()->with('success', 'Marque supprimée.');
    }

    public function entreprise()
    {
        return view('parametres.entreprise');
    }
}
