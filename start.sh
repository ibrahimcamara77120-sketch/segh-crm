#!/bin/bash
set -e

# Créer le fichier SQLite si absent
touch database/database.sqlite

# Installer les dépendances PHP si nécessaire
if [ ! -d "vendor" ]; then
  composer install --no-dev --optimize-autoloader
fi

# Générer la clé si absente
php artisan key:generate --force

# Lancer les migrations + seeders
php artisan migrate --force --seed

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
