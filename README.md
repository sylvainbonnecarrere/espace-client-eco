# 🌿 Espace Client Éco (Proof Of Concept)

![Vue.js](https://img.shields.io/badge/vuejs-%2335495e.svg?style=flat-square&logo=vuedotjs&logoColor=%234FC08D)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=flat-square&logo=laravel&logoColor=white)
![Blade](https://img.shields.io/badge/blade-%23FF2D20.svg?style=flat-square&logo=laravel&logoColor=white)
![TypeScript](https://img.shields.io/badge/typescript-%23007ACC.svg?style=flat-square&logo=typescript&logoColor=white)

Bienvenue sur la démonstration technique **"Espace Client Éco"**. Ce projet illustre une architecture moderne de portail client hybride conçue pour allier des performances haut niveau, une fluidité de type SPA (Single Page Application) et des standards de sécurité Entreprise avec notamment le MFA/2FA (TOTP).

## 🚀 La Stack Technologique

- **Architecture :** Monolithe Hybride découplé
- **Backend :** Laravel 13 (PHP 8.4) avec Strict Types
- **Frontend :** Vue.js 3 avec Composition API et **Inertia.js**
- **UI / UX :** Tailwind CSS v4 (Interface "Dashboard Cartes" Premium)
- **Data Fetching (Vue) :** VueUse `useFetch()`
- **Authentification :** Laravel Fortify (Headless MFA/2FA) + Laravel Sanctum (Tokens JWT API). Face aux fuites massives de données touchant de grands groupes et nombre de PME en 2026, **le MFA (TOTP) est rendu incontournable** pour toute mise en production d'Espace Client afin de prévenir le credential stuffing.
- **Moteur Asynchrone :** Redis (Cache et Queues)

> 🔬 **Documentation des tests & Assurance Qualité :** Consultez le document [tests/TESTING.md](tests/TESTING.md) pour les détails cruciaux d'audit et la validation 100% de la suite PEST / Vitest / E2E.

## 📌 Fonctionnalités Clés Implémentées

### 1. 🔒 Sécurité et Authentification
- Connexion classique (Email/Mot de passe).
- **MFA / 2FA :** Double authentification TOTP configurable via le profil utilisateur (Fortify).
- **Hardening :** `throttle:api` sur tous les endpoints pour bloquer le bruteforce, et protection CSRF via le pont Inertia.

### 2. 📊 API et Visualisation
- Affichage des contrats énergétiques de l'utilisateur.
- Chargement différé (Lazy Loading asynchrone) des données de consommation d'un contrat donné.
- Représentation graphique des consommations via **Chart.js** injectée dans le composant météo `ConsumptionsChart.vue`.

### 3. ⚡ Passage à l'échelle (Scaling)
- **Caching Eloquent :** Les appels sur `/api/contracts` sont mis en cache via Redis avec invalidation intelligente (`Cache::forget`) dès la création d'un contrat.
- **Asynchrone (Queues) :** La création d'un contrat délègue l'envoi d'emails au Worker Redis (`SendContractNotification`) limitant drastiquement le Time-To-First-Byte.

### 4. 🎓 Qualité du Logiciel (TDD)
- **Pest PHP** : Couverture sur l'authentification (MFA Challenge), le Cache Redis et les restrictions d'accès de l'API.
- **Scribe** : Documentation OpenAPI autogénérée (disponible sur `/docs`).

---

## 🛠️ Installation et Lancement

1. Clonez ce dépôt.
2. Installez les dépendances Composer et NPM :
```bash
composer install
npm install
```
3. Configurez votre environnement (`.env`) en vous assurant d'avoir une instance MySQL et Redis :
```env
DB_CONNECTION=mysql
QUEUE_CONNECTION=redis
CACHE_STORE=redis
```
4. Lancez les serveurs de développement (Le backend, le frontend Vite, et le Worker) :
```bash
php artisan serve
npm run dev
php artisan queue:work
```
5. **Vérifications et Audit Qualité (Validation 100%) :**
L'application est couverte par une suite de tests automatisés validant son fonctionnement et sa sécurité de manière absolue (Tests Pest, Vitest et Linting). Vous pouvez les exécuter via ces trois commandes de base :
```bash
php artisan test
npm run test:unit
composer run ci:check
```
> 👉 Pour le protocole complet, consultez la documentation détaillée des tests : [tests/TESTING.md](tests/TESTING.md)

## 📜 Documentation API
La documentation interactive des APIs est générée avec Scribe et disponible avec Exemples dynamiques sur le chemin `/docs` (requiert le serveur allumé).

> *Développé en tant que terrain de démonstration technique par Sylvain BONNECARRÈRE en 2025. MAJ le 23/04/2026 2026*
