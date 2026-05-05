<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CommandePiece extends Model {
    protected $table = 'commande_pieces';
    protected $fillable = ['commande_id', 'piece_id', 'quantite', 'prix_unitaire', 'disponible_sur_place'];
    protected $casts = ['disponible_sur_place' => 'boolean', 'prix_unitaire' => 'decimal:2'];

    public function commande() { return $this->belongsTo(Commande::class); }
    public function piece() { return $this->belongsTo(Piece::class); }
}
