<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Contract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendContractNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Contract $contract
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulation d'un envoi d'email lourd (SMTP/API Externe)
        // L'avantage des Queues avec Redis est que cet appel n'impacte pas le temps
        // de réponse pour le navigateur de l'utilisateur.

        // Simulation de délai réseau
        sleep(2); 

        // Enregistrement dans les logs pour validation ("Mock" métier)
        Log::info("Le contrat {$this->contract->reference} a été créé avec succès pour l'utilisateur ID {$this->contract->user_id}. Email d'activation envoyé.");
    }
}
