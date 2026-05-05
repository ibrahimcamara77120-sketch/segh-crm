<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->foreignId('vehicule_id')->nullable()->constrained('vehicules')->nullOnDelete();
            $table->enum('statut', ['en_attente', 'confirmee', 'en_preparation', 'prete', 'livree', 'annulee'])->default('en_attente');
            $table->enum('statut_paiement', ['non_paye', 'acompte', 'paye', 'rembourse'])->default('non_paye');
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->string('mode_paiement')->nullable();
            $table->date('date_paiement')->nullable();
            $table->string('ref_paiement')->nullable();
            $table->decimal('total_ht', 10, 2)->default(0);
            $table->decimal('tva', 10, 2)->default(0);
            $table->decimal('total_ttc', 10, 2)->default(0);
            $table->date('date_passage')->nullable();
            $table->date('date_rdv')->nullable();
            $table->boolean('commande_incomplete')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('commandes'); }
};
