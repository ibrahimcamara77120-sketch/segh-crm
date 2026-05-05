<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model {
    use HasFactory;
    protected $fillable = [
        'numero', 'client_id', 'vehicule_id', 'statut', 'statut_paiement',
        'montant_paye', 'mode_paiement', 'date_paiement', 'ref_paiement',
        'total_ht', 'tva', 'total_ttc', 'date_passage', 'date_rdv',
        'commande_incomplete', 'notes'
    ];
    protected $casts = [
        'date_passage' => 'date', 'date_rdv' => 'date', 'date_paiement' => 'date',
        'commande_incomplete' => 'boolean',
        'total_ht' => 'decimal:2', 'tva' => 'decimal:2', 'total_ttc' => 'decimal:2',
        'montant_paye' => 'decimal:2',
    ];

    public function client() { return $this->belongsTo(Client::class); }
    public function vehicule() { return $this->belongsTo(Vehicule::class); }
    public function pieces() { return $this->belongsToMany(Piece::class, 'commande_pieces')->withPivot('quantite', 'prix_unitaire', 'disponible_sur_place')->withTimestamps(); }
    public function commandePieces() { return $this->hasMany(CommandePiece::class); }
    public function paiements() { return $this->hasMany(Paiement::class); }
    public function interactions() { return $this->hasMany(Interaction::class); }

    public function getMontantRestantAttribute(): float {
        return max(0, $this->total_ttc - $this->montant_paye);
    }

    public static function genererNumero(): string {
        $annee = date('Y');
        $dernier = self::whereYear('created_at', $annee)->count();
        return 'CMD-' . $annee . '-' . str_pad($dernier + 1, 4, '0', STR_PAD_LEFT);
    }

    public function getStatutLabelAttribute(): string {
        return match($this->statut) {
            'en_attente' => 'En attente',
            'confirmee' => 'Confirmée',
            'en_preparation' => 'En préparation',
            'prete' => 'Prête à récupérer',
            'livree' => 'Livrée',
            'annulee' => 'Annulée',
            default => $this->statut,
        };
    }

    public function getStatutPaiementLabelAttribute(): string {
        return match($this->statut_paiement) {
            'non_paye' => 'Non payé',
            'acompte' => 'Acompte versé',
            'paye' => 'Payé intégralement',
            'rembourse' => 'Remboursé',
            default => $this->statut_paiement,
        };
    }
}
