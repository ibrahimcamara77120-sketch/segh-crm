<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model {
    use HasFactory;
    protected $fillable = ['client_id', 'commande_id', 'user_id', 'type', 'contenu', 'date'];
    protected $casts = ['date' => 'datetime'];

    public function client() { return $this->belongsTo(Client::class); }
    public function commande() { return $this->belongsTo(Commande::class); }
    public function user() { return $this->belongsTo(User::class); }

    public function getTypeLabelAttribute(): string {
        return match($this->type) {
            'appel' => 'Appel', 'email' => 'Email', 'visite' => 'Visite',
            'devis' => 'Devis', 'reclamation' => 'Réclamation',
            default => $this->type,
        };
    }
}
