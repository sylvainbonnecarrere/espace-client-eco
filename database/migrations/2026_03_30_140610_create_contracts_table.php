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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            // Lien avec l'utilisateur (Foreign Key)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Informations du contrat
            $table->string('reference')->unique();
            $table->date('start_date');
            $table->date('end_date')->nullable(); // La date de fin peut être nulle si le contrat court toujours
            $table->decimal('amount', 8, 2); // Prix mensuel
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
