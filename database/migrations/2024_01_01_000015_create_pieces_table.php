<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->foreignId('marque_id')->nullable()->constrained('marques')->nullOnDelete();
            $table->foreignId('categorie_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->decimal('prix_achat', 10, 2)->default(0);
            $table->decimal('prix_vente', 10, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->integer('seuil_alerte')->default(5);
            $table->string('photo')->nullable();
            $table->text('compatibilite')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pieces'); }
};
