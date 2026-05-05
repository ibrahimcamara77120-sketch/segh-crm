#!/bin/bash
echo "=== Installation Segh CRM ==="
echo ""

# Installer les dépendances PHP
echo ">> Installation des dépendances..."
composer install --no-dev --optimize-autoloader

# Générer la clé si absente
if ! grep -q "APP_KEY=base64:" .env 2>/dev/null; then
    echo ">> Génération de la clé d'application..."
    php artisan key:generate
fi

# Créer la base de données si absente
if [ ! -f "database/database.sqlite" ]; then
    echo ">> Création de la base de données..."
    touch database/database.sqlite
    php artisan migrate --seed --force
fi

# Permissions storage
chmod -R 775 storage bootstrap/cache 2>/dev/null

echo ""
echo "=== Installation terminée ==="
echo ""
echo "Lancer l'application : php artisan serve"
echo "Puis ouvrir : http://localhost:8000"
echo ""
echo "Connexion : admin@segh.fr / Segh2026!"
