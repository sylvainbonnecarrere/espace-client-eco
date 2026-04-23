<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un utilisateur avec le 2FA actif est redirigé vers le challenge', function () {
    // 1. Arrange : Créer un utilisateur avec 2FA activé
    $user = User::factory()->create([
        'two_factor_secret' => encrypt('secret_totp_key'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(), // Indique que l'utilisateur a finalisé son setup (scanné le QR)
    ]);

    // 2. Act : Tentative de Login (mot de passe valide)
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // 3. Assert : Redirection vers le challenge plutot que vers /dashboard
    $this->assertGuest(); // Toujours virtuellement guest car la session est en mode challenge
    $response->assertRedirect('/two-factor-challenge');
});

test('un utilisateur sans 2FA actif se connecte directement', function () {
    // 1. Arrange : Créer un utilisateur SANS 2FA
    $user = User::factory()->create([
        'two_factor_secret' => null,
    ]);

    // 2. Act
    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    // 3. Assert
    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/dashboard');
});
