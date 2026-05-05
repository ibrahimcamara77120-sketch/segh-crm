<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model {
    use HasFactory;
    protected $fillable = [
        'client_id', 'immatriculation', 'marque', 'modele', 'version',
        'annee', 'vin', 'km', 'carburant', 'couleur', 'notes_meca'
    ];
    public function client() { return $this->belongsTo(Client::class); }
    public function commandes() { return $this->hasMany(Commande::class); }
    public function commandePieces() {
        return $this->hasManyThrough(CommandePiece::class, Commande::class);
    }
}
