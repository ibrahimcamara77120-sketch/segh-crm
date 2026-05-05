<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected function casts(): array {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isCommercial(): bool { return $this->role === 'commercial'; }
    public function isTechnicien(): bool { return $this->role === 'technicien'; }
    public function interactions() { return $this->hasMany(Interaction::class); }
    public function paiements() { return $this->hasMany(Paiement::class); }
}
