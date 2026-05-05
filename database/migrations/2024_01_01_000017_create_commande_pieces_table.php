<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('commande_pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->onDelete('cascade');
            $table->foreignId('piece_id')->constrained()->onDelete('restrict');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire', 10, 2);
            $table->boolean('disponible_sur_place')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('commande_pieces'); }
};
