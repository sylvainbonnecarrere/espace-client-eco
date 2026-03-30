# Espace Client Éco 🌿

Ce projet est une application web full-stack développée dans le but de s'entraîner et de maîtriser un environnement de développement moderne : le backend Laravel et le frontend Vue.js. Il s'agit d'un "Espace Client" permettant la visualisation de contrats d'énergie et de l'historique de consommation.

## 🛠️ Stack Technique

* **Backend :** Laravel 11/13.x (API REST, Eloquent ORM, Migrations).
* **Frontend :** Vue.js 3 (Composition API) propulsé par Inertia.js et stylisé avec Tailwind CSS.
* **Base de données :** MySQL 8.0 tournant de manière isolée sur Docker.
* **Outils Locaux :** Docker Compose sécurisé, Vite.js (HMR), et Pest PHP pour les futurs tests.

## 🚀 Démarrage Rapide (Environnement local)

1. **Cloner le projet** et entrer dans le dossier `espace_client_eco`.
2. **Installer les dépendances :**
   ```bash
   composer install && npm install
3. **Configurer l'environnement** : Copiez .env.example vers .env et assurez-vous que vos identifiants MySQL correspondent :
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=espace_client_eco
DB_USERNAME=root
DB_PASSWORD=password
4. **Lancer la base de données** :
bash
docker-compose up -d
(phpMyAdmin est disponible sur http://localhost:8080)
5. **Générer la structure BDD et les fausses données** :
bash
php artisan migrate:fresh --seed
6. **Démarrer les serveurs** (dans 2 terminaux séparés) :
bash
npm run dev
php artisan serve
Accédez à l'application sur http://localhost:8000 !    
