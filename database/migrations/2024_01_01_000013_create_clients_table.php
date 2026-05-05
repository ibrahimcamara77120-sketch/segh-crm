<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['particulier', 'professionnel'])->default('particulier');
            $table->enum('civilite', ['M.', 'Mme'])->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('raison_sociale')->nullable();
            $table->string('contact_nom')->nullable();
            $table->string('contact_prenom')->nullable();
            $table->string('contact_poste')->nullable();
            $table->string('email')->nullable();
            $table->string('tel_mobile')->nullable();
            $table->string('tel_fixe')->nullable();
            $table->string('adresse')->nullable();
            $table->string('complement_adresse')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('ville')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('siret', 14)->nullable();
            $table->string('tva_intra')->nullable();
            $table->decimal('remise_pct', 5, 2)->default(0);
            $table->enum('conditions_reglement', ['comptant', '30_jours', '60_jours'])->default('comptant');
            $table->string('iban')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('clients'); }
};
