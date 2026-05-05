<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('commande_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['appel', 'email', 'visite', 'devis', 'reclamation']);
            $table->text('contenu');
            $table->timestamp('date');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('interactions'); }
};
