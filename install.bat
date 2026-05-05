@echo off
echo === Installation Segh CRM ===
echo.

echo >> Installation des dependances...
composer install --no-dev --optimize-autoloader

echo >> Verification de la cle d'application...
php artisan key:generate --no-interaction

echo >> Verification de la base de donnees...
IF NOT EXIST "database\database.sqlite" (
    echo Creation de la base de donnees...
    type nul > database\database.sqlite
    php artisan migrate --seed --force
)

echo.
echo === Installation terminee ===
echo.
echo Lancer l'application : php artisan serve
echo Puis ouvrir : http://localhost:8000
echo.
echo Connexion : admin@segh.fr / Segh2026!
echo.
pause
