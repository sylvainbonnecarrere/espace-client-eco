<?php

declare(strict_types=1);

use App\Models\Consumption;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a contract belongs to a user', function () {
    // 1. Arrange
    $user = User::factory()->create();
    $contract = Contract::factory()->create(['user_id' => $user->id]);

    // 2. Act
    $contractUser = $contract->user;

    // 3. Assert
    expect($contractUser->id)->toBe($user->id);
});

test('a contract can have many consumptions', function () {
    // 1. Arrange
    $contract = Contract::factory()->create();
    $consumptions = Consumption::factory()->count(3)->create([
        'contract_id' => $contract->id,
    ]);

    // 2. Act
    $contractConsumptions = $contract->consumptions;

    // 3. Assert
    expect($contractConsumptions)->toHaveCount(3);
    expect($contractConsumptions->first()->id)->toBe($consumptions->first()->id);
});
