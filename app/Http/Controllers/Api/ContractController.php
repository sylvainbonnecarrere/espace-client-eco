<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contracts\StoreContractRequest;
use App\Http\Resources\ContractResource;
use App\Jobs\SendContractNotification;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ContractController extends Controller
{
    /**
     * @group Contrats
     *
     * @authenticated
     *
     * Liste des contrats.
     * Récupère la liste paginée et paramétrée de l'ensemble des contrats de l'utilisateur.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        // Mise en cache des contrats par utilisateur pendant 10 minutes sous Redis
        $contracts = Cache::remember("user:{$userId}:contracts", now()->addMinutes(10), function () use ($request) {
            return $request->user()->contracts()->latest()->get();
        });

        return ContractResource::collection($contracts);
    }

    /**
     * @group Contrats
     *
     * @authenticated
     *
     * Créer un contrat.
     * Enregistre un nouveau contrat énergétique lié à l'utilisateur courant.
     */
    public function store(StoreContractRequest $request)
    {
        // La validation est gérée par StoreContractRequest
        $contract = $request->user()->contracts()->create($request->validated());

        // Invalidation du cache car une nouvelle donnée a été ajoutée
        Cache::forget("user:{$request->user()->id}:contracts");

        // Envoi asynchrone dans Redis pour ne pas bloquer l'utilisateur
        SendContractNotification::dispatch($contract);

        return new ContractResource($contract);
    }

    /**
     * Obtenir les détails d'un contrat spécifique
     */
    public function show(Request $request, Contract $contract)
    {
        // Autorisation: est-ce bien le contrat de cet utilisateur ?
        if ($contract->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized access to this contract.');
        }

        return new ContractResource($contract->load('consumptions'));
    }

    /**
     * Récupérer spécifiquement les consommations liées à un contrat (pour Chart.js)
     */
    public function consumptions(Request $request, Contract $contract)
    {
        if ($contract->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized access to this contract.');
        }

        // On pourrait faire une ConsumptionsResource, mais restons simple pour chart.js
        return response()->json($contract->consumptions()->orderBy('month')->get());
    }
}
