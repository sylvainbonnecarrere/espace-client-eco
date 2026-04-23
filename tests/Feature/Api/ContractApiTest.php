<?php

declare(strict_types=1);

use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

test('un utilisateur non authentifié ne peut pas lister les contrats', function () {
    // 1. Arrange (Rien, aucun user)

    // 2. Act
    $response = $this->getJson('/api/contracts');

    // 3. Assert
    $response->assertStatus(401);
});

test('un utilisateur peut lister uniquement ses propres contrats', function () {
    // 1. Arrange
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    Contract::factory()->create(['user_id' => $user1->id, 'reference' => 'CONT-USER1']);
    Contract::factory()->create(['user_id' => $user2->id, 'reference' => 'CONT-USER2']);

    Sanctum::actingAs($user1);

    // 2. Act
    $response = $this->getJson('/api/contracts');

    // 3. Assert
    $response->assertStatus(200);
    $response->assertJsonCount(1, 'data');
    $response->assertJsonPath('data.0.reference', 'CONT-USER1');
    $response->assertJsonMissing(['reference' => 'CONT-USER2']);
});

test('la ressource API cache les champs sensibles', function () {
    // 1. Arrange
    $user = User::factory()->create();
    Contract::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    // 2. Act
    $response = $this->getJson('/api/contracts');

    // 3. Assert
    $response->assertStatus(200);
    // Vérifier que la ressource ne renvoie pas l'ID de l'utilisateur ou d'autres secrets
    $data = $response->json('data.0');
    expect($data)->not->toHaveKey('user_id');
    expect($data)->toHaveKey('amount');
});
