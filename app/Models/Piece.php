<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model {
    use HasFactory;
    protected $fillable = [
        'reference', 'nom', 'description', 'marque_id', 'categorie_id',
        'prix_achat', 'prix_vente', 'stock', 'seuil_alerte', 'photo', 'compatibilite'
    ];
    protected $casts = ['prix_achat' => 'decimal:2', 'prix_vente' => 'decimal:2'];

    public function marque() { return $this->belongsTo(Marque::class); }
    public function categorie() { return $this->belongsTo(Categorie::class); }
    public function commandePieces() { return $this->hasMany(CommandePiece::class); }

    public function getStockStatusAttribute(): string {
        if ($this->stock <= 0) return 'rupture';
        if ($this->stock <= $this->seuil_alerte) return 'alerte';
        return 'ok';
    }
}
