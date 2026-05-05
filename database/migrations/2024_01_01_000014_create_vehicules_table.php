<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('immatriculation');
            $table->string('marque');
            $table->string('modele');
            $table->string('version')->nullable();
            $table->year('annee')->nullable();
            $table->string('vin', 17)->nullable();
            $table->integer('km')->nullable();
            $table->enum('carburant', ['essence', 'diesel', 'hybride', 'electrique'])->nullable();
            $table->string('couleur')->nullable();
            $table->text('notes_meca')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('vehicules'); }
};
