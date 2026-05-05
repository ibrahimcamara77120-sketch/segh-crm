<?php
use App\Http\Controllers\{
    DashboardController, ClientController, VehiculeController, PieceController,
    CommandeController, InteractionController, AlerteController, ParametreController
};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/dashboard'));

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Clients
    Route::resource('clients', ClientController::class);
    Route::get('/clients/{client}/historique', [ClientController::class, 'historique'])->name('clients.historique');

    // Véhicules (nested sous clients)
    Route::resource('clients.vehicules', VehiculeController::class);

    // Interactions
    Route::get('/clients/{client}/interactions', [InteractionController::class, 'index'])->name('clients.interactions.index');
    Route::post('/clients/{client}/interactions', [InteractionController::class, 'store'])->name('clients.interactions.store');
    Route::delete('/clients/{client}/interactions/{interaction}', [InteractionController::class, 'destroy'])->name('clients.interactions.destroy');

    // Pièces
    Route::get('/pieces/alertes-stock', [PieceController::class, 'alertesStock'])->name('pieces.alertes');
    Route::get('/pieces/{piece}/stock', [PieceController::class, 'stock'])->name('pieces.stock');
    Route::resource('pieces', PieceController::class);

    // Commandes
    Route::resource('commandes', CommandeController::class);
    Route::patch('/commandes/{commande}/statut', [CommandeController::class, 'updateStatut'])->name('commandes.statut');
    Route::post('/commandes/{commande}/paiement', [CommandeController::class, 'enregistrerPaiement'])->name('commandes.paiement');
    Route::get('/commandes/{commande}/verifier-stock', [CommandeController::class, 'verifierStock'])->name('commandes.verifier-stock');
    Route::get('/commandes/{commande}/pdf', [CommandeController::class, 'pdf'])->name('commandes.pdf');

    // Alertes
    Route::get('/alertes', [AlerteController::class, 'index'])->name('alertes.index');

    // Paramètres (admin only)
    Route::middleware(['role:admin'])->prefix('parametres')->name('parametres.')->group(function () {
        Route::get('/utilisateurs', [ParametreController::class, 'utilisateurs'])->name('utilisateurs');
        Route::post('/utilisateurs', [ParametreController::class, 'storeUtilisateur'])->name('utilisateurs.store');
        Route::put('/utilisateurs/{user}', [ParametreController::class, 'updateUtilisateur'])->name('utilisateurs.update');
        Route::delete('/utilisateurs/{user}', [ParametreController::class, 'destroyUtilisateur'])->name('utilisateurs.destroy');

        Route::get('/categories', [ParametreController::class, 'categories'])->name('categories');
        Route::post('/categories', [ParametreController::class, 'storeCategorie'])->name('categories.store');
        Route::put('/categories/{categorie}', [ParametreController::class, 'updateCategorie'])->name('categories.update');
        Route::delete('/categories/{categorie}', [ParametreController::class, 'destroyCategorie'])->name('categories.destroy');

        Route::get('/marques', [ParametreController::class, 'marques'])->name('marques');
        Route::post('/marques', [ParametreController::class, 'storeMarque'])->name('marques.store');
        Route::put('/marques/{marque}', [ParametreController::class, 'updateMarque'])->name('marques.update');
        Route::delete('/marques/{marque}', [ParametreController::class, 'destroyMarque'])->name('marques.destroy');

        Route::get('/entreprise', [ParametreController::class, 'entreprise'])->name('entreprise');
    });
});
