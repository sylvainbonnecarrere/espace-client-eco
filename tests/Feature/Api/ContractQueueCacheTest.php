<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Contract;
use App\Jobs\SendContractNotification;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('store a contract triggers the SendContractNotification job seamlessly', function () {
    // 1. Arrange
    Queue::fake(); // Empêche l'exécution réelle et intercepte les requêtes de Queue
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $payload = [
        'reference' => 'TEST-REDIS-1',
        'amount' => 55.50,
        'start_date' => '2026-05-01'
    ];

    // 2. Act
    $response = $this->postJson('/api/contracts', $payload);

    // 3. Assert
    $response->assertStatus(201);
    
    // Vérifie que le Job asynchrone a bien été envoyé en file d'attente
    Queue::assertPushed(SendContractNotification::class, function ($job) {
        return $job->contract->reference === 'TEST-REDIS-1';
    });
});

test('index contracts caches the response successfully', function () {
    // 1. Arrange
    $user = User::factory()->create();
    Contract::factory()->create(['user_id' => $user->id, 'reference' => 'CACHE-1']);
    Sanctum::actingAs($user);

    $cacheKey = "user:{$user->id}:contracts";
    Cache::forget($cacheKey);

    // 2. Act : Premier appel, met en cache
    $this->getJson('/api/contracts')->assertStatus(200);

    // 3. Assert
    expect(Cache::has($cacheKey))->toBeTrue();

    // 4. Arrange cache invalidation test
    // On ajoute un contrat via l'API, cela doit casser le cache
    $this->postJson('/api/contracts', [
        'reference' => 'CACHE-2-NEW',
        'amount' => 120,
        'start_date' => '2026-05-01'
    ])->assertStatus(201);

    // 5. Assert: The cache should be invalidated
    expect(Cache::has($cacheKey))->toBeFalse();
});
