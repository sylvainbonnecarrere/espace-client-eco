Plan Général du Projet "Espace Client Éco"
Durée estimée : 7–10 jours (à adapter selon ton rythme).

Objectif : Construire une application full-stack avec Laravel (backend) + Vue.js (frontend), en couvrant les compétences clés de la fiche de poste.

📌 Phase 1 : Fondations (2 jours)
1.1. Structure du Projet et Authentification
Objectif : Finaliser l’installation de base et implémenter l’authentification avec Sanctum.

Stack : Laravel (Sanctum), Vue.js (Pinia), MySQL.


  
    
      Tâche
      Détails
      Ressources/Explications
    
  
  
    
      1.1.1. Vérifier l’installation
      - Vérifie que php artisan serve et npm run dev fonctionnent.
      Doc Laravel Installation
    
    
      1.1.2. Configurer Sanctum
      - Publier les fichiers de config : php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider".
      Explication : Sanctum est une solution légère pour l’authentification API (alternative à OAuth2). Il utilise des tokens JWT stockés en base.
    
    
      1.1.3. Créer les modèles User/Contract
      - Générer les migrations et modèles : php artisan make:model User -m, php artisan make:model Contract -m.
      Explication : Les migrations définissent la structure de la base (ex: users, contracts). Les modèles (ex: User) permettent d’interagir avec les données via Eloquent.
    
    
      1.1.4. Routes d’authentification
      - Créer AuthController avec méthodes login, logout, user.
      Exemple de code : AuthController avec Sanctum
    
    
      1.1.5. Frontend : Login avec Vue.js
      - Créer une page de login avec Pinia pour gérer l’état de l’utilisateur.
      Explication : Pinia est un store centralisé pour Vue.js (comme Redux pour React). Il permet de gérer le token JWT et l’état de connexion.
    
  


✅ Livrable :

Un utilisateur peut s’authentifier et voir ses informations (route /api/user protégée).
Frontend : Page de login fonctionnelle + affichage des infos utilisateur.

1.2. Configuration de la Base de Données
Objectif : Créer les tables contracts et consumptions (pour les données de consommation).

Stack : Laravel (Migrations, Eloquent), MySQL.


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      1.2.1. Migration pour contracts
      - Ajouter les champs : user_id (clé étrangère), reference, start_date, end_date, amount.
      Exemple : Schema::create('contracts', function (Blueprint $table) { $table->foreignId('user_id')->constrained(); ... });
    
    
      1.2.2. Migration pour consumptions
      - Table liée à contracts avec contract_id, month, value.
      Explication : Une table de consommation mensuelle pour chaque contrat.
    
    
      1.2.3. Relations Eloquent
      - Dans User.php : public function contracts() { return $this->hasMany(Contract::class); }
      Explication : Eloquent gère les relations (ex: un utilisateur a plusieurs contrats).
    
    
      1.2.4. Seeders pour les tests
      - Créer des données de test : php artisan make:seeder ContractSeeder.
      Exemple : Contract::factory()->count(10)->create();
    
  


✅ Livrable :

Base de données prête avec des données de test.
Relations Eloquent fonctionnelles (ex: $user->contracts).

📌 Phase 2 : API et Frontend (3 jours)
2.1. API REST pour les Contrats
Objectif : Créer une API CRUD pour gérer les contrats.

Stack : Laravel (API Resources, Validation), Vue.js (Axios).


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      2.1.1. Contrôleur ContractController
      - Générer : php artisan make:controller ContractController --api.
      Explication : Un contrôleur API ne retourne que des réponses JSON (pas de vues Blade).
    
    
      2.1.2. Routes API
      - Définir les routes dans routes/api.php : Route::apiResource('contracts', ContractController::class)->middleware('auth:sanctum');.
      Explication : apiResource génère automatiquement les routes REST (index, store, show, update, destroy).
    
    
      2.1.3. Validation des requêtes
      - Utiliser FormRequest : php artisan make:request StoreContractRequest.
      Exemple : `public function rules() { return ['reference' => 'required
    
    
      2.1.4. API Resources
      - Créer une ressource : php artisan make:resource ContractResource.
      Explication : Les ressources transforment les modèles en JSON (ex: masquer des champs sensibles).
    
    
      2.1.5. Frontend : Liste des contrats
      - Afficher les contrats dans un tableau Vue.js avec Axios pour récupérer les données.
      Exemple : const contracts = ref([]); onMounted(async () => { contracts.value = (await axios.get('/api/contracts')).data; });
    
  


✅ Livrable :

API fonctionnelle pour les contrats (CRUD complet).
Frontend : Liste des contrats affichée dans un tableau.

2.2. Graphiques avec Chart.js
Objectif : Afficher des données de consommation sous forme de graphiques.

Stack : Laravel (API pour les données), Vue.js (Chart.js).


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      2.2.1. Route pour les consommations
      - Ajouter dans ContractController : public function consumption(Contract $contract) { return $contract->consumptions; }.
      Explication : Une route dédiée pour récupérer les données de consommation d’un contrat.
    
    
      2.2.2. Frontend : Intégrer Chart.js
      - Installer Chart.js : npm install chart.js vue-chartjs.
      Exemple :  avec chartData calculé depuis les données API.
    
  


✅ Livrable :

Graphique affichant la consommation mensuelle d’un contrat.

📌 Phase 3 : Fonctionnalités Avancées (2 jours)
3.1. Files d’Attente (Queues)
Objectif : Simuler l’envoi d’emails/notifications en arrière-plan.

Stack : Laravel (Queues, Jobs), Redis (en local).


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      3.1.1. Configurer Redis
      - Installer Redis : composer require predis/predis.
      Explication : Redis est un store clé-valeur utilisé pour les files d’attente, le cache, etc.
    
    
      3.1.2. Créer un Job
      - Générer un job : php artisan make:job SendContractNotification.
      Exemple : public function handle() { Mail::to($this->user)->send(new ContractNotification($this->contract)); }
    
    
      3.1.3. Dispatcher le Job
      - Dans ContractController : SendContractNotification::dispatch($contract)->onQueue('emails');.
      Explication : dispatch envoie le job à la file d’attente.
    
    
      3.1.4. Lancer le worker
      - Démarrer le worker : php artisan queue:work.
      Explication : Le worker écoute les jobs et les exécute.
    
  


✅ Livrable :

Un email de notification est envoyé en arrière-plan quand un contrat est créé.

3.2. Cache
Objectif : Optimiser les performances avec le cache.

Stack : Laravel (Cache), Redis.


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      3.2.1. Configurer le cache
      - Dans .env : CACHE_DRIVER=redis.
      Explication : Le cache stocke des données fréquemment accédées (ex: résultats de requêtes).
    
    
      3.2.2. Cacher les contrats
      - Dans ContractController : return Cache::remember("user:{$user->id}:contracts", now()->addHours(1), fn() => $user->contracts);.
      Exemple : Les contrats d’un utilisateur sont mis en cache pendant 1 heure.
    
  


✅ Livrable :

Les requêtes répétées sur /api/contracts sont servies depuis le cache.

📌 Phase 4 : Sécurité et Optimisation (1 jour)
4.1. Sécurité (OWASP)
Objectif : Appliquer les bonnes pratiques de sécurité.

Stack : Laravel (Middleware, Validation), CORS.


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      4.1.1. Middleware CORS
      - Installer fruitcake/laravel-cors et configurer config/cors.php.
      Explication : CORS restreint les origines autorisées à accéder à ton API.
    
    
      4.1.2. Validation stricte
      - Utiliser FormRequest pour valider toutes les entrées.
      Exemple : `public function rules() { return ['email' => 'required
    
    
      4.1.3. Rate Limiting
      - Ajouter dans routes/api.php : Route::middleware('throttle:60,1')->group(...);.
      Explication : Limite le nombre de requêtes par minute pour éviter les attaques par force brute.
    
  


✅ Livrable :

API sécurisée contre les attaques courantes (injection SQL, XSS, etc.).

4.2. Tests et Documentation
Objectif : Garantir la qualité du code.

Stack : PHPUnit (Backend), Vitest (Frontend), Scribe (Documentation API).


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      4.2.1. Tests PHPUnit
      - Créer un test pour AuthController : php artisan make:test AuthControllerTest.
      Exemple : public function test_login_returns_token() { $response = $this->postJson('/api/login', ['email' => 'test@example.com', 'password' => 'password']); $response->assertStatus(200); }
    
    
      4.2.2. Documentation API
      - Générer la doc avec Scribe : php artisan scribe:generate.
      Explication : Scribe génère une documentation interactive pour ton API.
    
  


✅ Livrable :

Tests unitaires pour les fonctionnalités critiques.
Documentation API complète.

📌 Phase 5 : Déploiement et CI/CD (1 jour)
Objectif : Automatiser le déploiement (simulation locale avec Docker).

Stack : Docker, GitHub Actions.


  
    
      Tâche
      Détails
      Explications
    
  
  
    
      5.1. Dockeriser l’application
      - Configurer Dockerfile et docker-compose.yml pour Laravel + MySQL + Redis.
      Exemple : docker-compose.yml avec services pour app, mysql, redis.
    
    
      5.2. CI/CD avec GitHub Actions
      - Créer un workflow .github/workflows/test.yml pour lancer les tests à chaque push.
      Exemple : php artisan test et npm run test dans le workflow.
    
  


✅ Livrable :

Application dockerisée et prête pour un déploiement.
Pipeline CI/CD qui exécute les tests automatiquement.

📅 Planning Hebdomadaire Suggesté


  
    
      Jour
      Phase
      Tâches Principales
    
  
  
    
      Jour 1
      1.1
      Authentification + modèles de base.
    
    
      Jour 2
      1.2
      Base de données + relations Eloquent.
    
    
      Jour 3
      2.1
      API REST pour les contrats.
    
    
      Jour 4
      2.2
      Frontend (Vue.js) + graphiques.
    
    
      Jour 5
      3.1
      Files d’attente (Queues) + Redis.
    
    
      Jour 6
      3.2 + 4.1
      Cache + sécurité (CORS, validation).
    
    
      Jour 7
      4.2 + 5.1
      Tests + documentation + Docker.
    
  



🔍 Points Clés à Retenir par Stack
Laravel


  
    
      Concept
      Explication
      Exemple
    
  
  
    
      Eloquent
      ORM pour interagir avec la base de données.
      $user->contracts (relation one-to-many).
    
    
      Sanctum
      Authentification API via tokens.
      Auth::attempt($credentials) + $user->createToken().
    
    
      Queues
      Exécution différée de tâches (ex: envoi d’emails).
      SendContractNotification::dispatch($contract).
    
    
      Cache
      Stocke des données en mémoire pour accélérer les requêtes.
      Cache::remember("key", $ttl, $callback).
    
    
      API Resources
      Transforme les modèles en JSON.
      return new ContractResource($contract);.
    
  


Vue.js


  
    
      Concept
      Explication
      Exemple
    
  
  
    
      Pinia
      Gestion d’état centralisée.
      const authStore = useAuthStore();.
    
    
      Axios
      Requêtes HTTP vers l’API.
      axios.get('/api/contracts', { headers: { Authorization: Bearer ${token} } });.
    
    
      Chart.js
      Graphiques interactifs.
      .
    
  


Sécurité


  
    
      Concept
      Explication
      Exemple
    
  
  
    
      CORS
      Restreint les origines autorisées à accéder à l’API.
      allowed_origins => ['http://localhost:3000'].
    
    
      Validation
      Vérifie les entrées utilisateur.
      `$request->validate(['email' => 'required
    
    
      Rate Limiting
      Limite le nombre de requêtes par IP.
      Route::middleware('throttle:60,1').
    
  


