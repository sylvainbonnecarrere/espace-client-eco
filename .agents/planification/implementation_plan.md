# Plan de Développement : Espace Client Éco (Phase 1)

Ce plan global couvre notre objectif de création d'une application d'espace client full-stack (Laravel + Vue.js) en se basant sur la documentation restaurée dans `projet.md`.

## User Review Required

> [!IMPORTANT]
> Voici le plan de marche actualisé tenant compte des spécificités MySQL sécurisées et de la pédagogie Vue.js/Laravel enrichie des sources officielles. Veuillez valider pour que j'applique les modifications de sécurité sur le conteneur Docker et sur nos fichiers d'agents !

## 1. Sécurisation de l'infrastructure Locale (MySQL + Docker)

> [!CAUTION]
> **Problème identifié** : Les mots de passe en clair dans `docker-compose.yml` risquent d'être poussés sur Git.
> **Solution** : Nous n'écrirons aucun identifiant en dur dans `docker-compose.yml`. Le conteneur ira lire directement les identifiants depuis votre fichier `.env` local (qui est ignoré par Git via `.gitignore`).

- **Modification** de `docker-compose.yml` pour utiliser `${DB_USERNAME}` et `${DB_PASSWORD}`.
- Nous utiliserons la base `espace_client_eco` définie dans le `.env` de Laravel.

## 2. Mise à jour des Agents Pédagogiques (Sources Officielles)

Les agents ont besoin de connaître les sources de vérité absolues pour garantir un code pertinent et à jour :
- **Agent Laravel** : Intégration stricte de la [documentation officielle Laravel 13.x](https://laravel.com/docs/13.x) et des bonnes pratiques de test unitaire via [Pest PHP](https://pestphp.com/docs/installation).
- **Agent Vue.js** : Intégration de la [documentation essentielle Vue.js / Composition API](https://vuejs.org/guide/introduction).

## 3. Déploiement de la Phase 1 (Authentification & Base de données)

Sur la base du `projet.md` :
1. **Démarrer l'infrastructure** avec `docker-compose up -d` après sécurisation.
2. **Migrations Initiales** : Créer les modèles `Contract` et `Consumption`.
3. **Relations Eloquent** : Mettre en place la relation (1 Utilisateur a X Contrats, 1 Contrat a X Consommations).
4. **Seeders** : Peupler cette base de test sécurisée.
5. **Validation Vue.js** : Vérifier que l'interface de connexion basée sur Inertia et Vue 3 communique bien avec le nouveau backend MySQL.

## Open Questions

> [!QUESTION]
> Est-ce que cette approche de sécurité (utiliser le `.env` de Laravel pour le conteneur Docker) et ces ajouts aux agents vous conviennent parfaitement ? Si oui, je déploie ces changements sur nos 3 fichiers correspondants.
