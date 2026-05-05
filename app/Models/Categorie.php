<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {
    use HasFactory;
    protected $fillable = ['nom', 'couleur'];
    public function pieces() { return $this->hasMany(Piece::class); }
}
