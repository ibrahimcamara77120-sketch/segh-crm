<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    use HasFactory;
    protected $fillable = [
        'type', 'civilite', 'nom', 'prenom', 'raison_sociale', 'contact_nom',
        'contact_prenom', 'contact_poste', 'email', 'tel_mobile', 'tel_fixe',
        'adresse', 'complement_adresse', 'code_postal', 'ville', 'date_naissance',
        'siret', 'tva_intra', 'remise_pct', 'conditions_reglement', 'iban',
        'source', 'notes'
    ];
    protected $casts = ['date_naissance' => 'date', 'remise_pct' => 'decimal:2'];

    public function vehicules() { return $this->hasMany(Vehicule::class); }
    public function commandes() { return $this->hasMany(Commande::class); }
    public function interactions() { return $this->hasMany(Interaction::class); }

    public function getNomCompletAttribute(): string {
        if ($this->type === 'professionnel') return $this->raison_sociale ?? '';
        return trim(($this->civilite ?? '') . ' ' . ($this->prenom ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function getTotalDepenseAttribute(): float {
        return $this->commandes()->whereIn('statut', ['livree', 'prete'])->sum('total_ttc');
    }

    public function getIsParticulierAttribute(): bool { return $this->type === 'particulier'; }
    public function getIsProAttribute(): bool { return $this->type === 'professionnel'; }
}
