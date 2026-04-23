# Stratégie et Exécution des Tests 🛡️

Ce document explique comment valider l'intégrité globale de l'application. La "Pyramide des Tests" couvre ici : le backend (Pest), le frontend (Vitest) et le navigateur (Dusk).

## 1. Tests API & Backend (Pest PHP)
L'intelligence métier, l'authentification et les routes API sont sécurisées via Pest. Ces tests isolent l'environnement (base de données de test en mémoire, désactivation du vrai Redis via `Queue::fake()`).

```bash
# Lancer tous les tests backend
php artisan test

# Lancer un test spécifique (Ex: MFA Challenge)
php artisan test --filter TwoFactorAuthenticationTest
```

## 2. Tests Composants (Vitest)
L'application Vue.js contient des composants isolés. Ils nécessitent JS DOM pour simuler le navigateur sans l'ouvrir.
```bash
# Vérifier la solidité des composants Vue
npm run test:unit
```

## 3. L'Audit Général (CI/CD Local Automatisé)
Pour un rapport 100% de validation globale avant mise en production (Analyses statiques + Tests) :

```bash
# Lance le formatage, l'analyse des types et la suite [test]
npm run ci:check
```

*Note: La sécurité est le nerf de la guerre. Les tests couvrent spécifiquement notre mécanisme de Rate Limiting et la barrière Infranchissable (TDD) du `TwoFactorAuthenticationTest` qui prouve que l'accès Dashboard est strictement interdit sans code TOTP.*
