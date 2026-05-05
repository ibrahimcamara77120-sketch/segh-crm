# Segh CRM — Installation

## Prérequis
- PHP 8.1 ou supérieur (avec extensions : pdo_sqlite, mbstring, openssl, tokenizer, xml, ctype, json)
- Composer (https://getcomposer.org)

## Installation en 3 étapes

### 1. Extraire l'archive
Décompresser `segh-crm.zip` dans le dossier de votre choix.

### 2. Installer les dépendances

**Mac / Linux — ouvrir le Terminal dans le dossier extrait :**
```
chmod +x install.sh && ./install.sh
```

**Windows — double-cliquer sur `install.bat`**
*(ou ouvrir l'invite de commandes dans le dossier et taper : `install.bat`)*

### 3. Lancer l'application
```
php artisan serve
```
Puis ouvrir **http://localhost:8000** dans le navigateur.

---

## Connexion
- **Email :** admin@segh.fr
- **Mot de passe :** Segh2026!

## Créer d'autres utilisateurs
Paramètres → Utilisateurs → Nouvel utilisateur
Rôles disponibles : Admin, Commercial, Technicien

---

*Application développée avec Laravel 11 + SQLite (base de données incluse, aucune configuration serveur nécessaire)*
