<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consumptions', function (Blueprint $table) {
            $table->id();
            // Lien avec le Contrat (Foreign Key)
            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();
            // Données de facturation
            $table->string('month'); // Ex: '2026-03'
            $table->decimal('value', 8, 2); // Consommation en kWh par exemple
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consumptions');
    }
};
