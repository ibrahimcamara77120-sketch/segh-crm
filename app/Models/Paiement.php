<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model {
    use HasFactory;
    protected $fillable = ['commande_id', 'user_id', 'montant', 'mode', 'reference', 'date', 'notes'];
    protected $casts = ['date' => 'date', 'montant' => 'decimal:2'];

    public function commande() { return $this->belongsTo(Commande::class); }
    public function user() { return $this->belongsTo(User::class); }
}
