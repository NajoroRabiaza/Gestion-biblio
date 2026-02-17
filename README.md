# Système de Gestion de Bibliothèque - Guide d'Installation

Ce guide vous permettra d'installer l'environnement de développement localement sur votre machine.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

* **PHP** (8.0 ou +) & **MySQL** (via XAMPP, Laragon ou MAMP).
* **Composer** (Gestionnaire de dépendances PHP).
* **Node.js & NPM** (Pour le CSS/JS).

---

## Étapes d'installation

### 1. Extraction du projet

* Téléchargez le fichier `Projet_Base_V1.zip` depuis le Drive.
* Extrayez-le dans votre dossier de projets (ex: `C:/xampp/htdocs/` ou votre dossier Bureau).

### 2. Installation des dépendances PHP

Ouvrez un terminal dans le dossier du projet et lancez :

```bash
composer install

```

*Cela va créer le dossier `vendor/` avec toutes les bibliothèques Laravel.*

### 3. Configuration de la base de données

1. Ouvrez votre navigateur sur **phpMyAdmin**.
2. Créez une nouvelle base de données nommée : `gestion_biblio`.

### 4. Configuration du fichier .env

1. Dans le dossier du projet, trouvez le fichier `.env.example`.
2. Renommez-le (ou faites une copie) en **`.env`**.
3. Ouvrez le fichier `.env` avec un éditeur (VS Code ou Bloc-notes) et modifiez ces lignes :

**Pour Windows (XAMPP) :**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_biblio
DB_USERNAME=root
DB_PASSWORD=

```

*(Laissez le mot de passe vide si vous n'en avez pas mis sur XAMPP).*

### 5. Initialisation de l'application

Retournez dans le terminal et exécutez ces deux commandes :

```bash
php artisan key:generate
php artisan migrate

```

*La première sécurise l'application, la seconde crée les tables dans votre base de données.*

### 6. Lancement du projet

```bash
php artisan serve

```

Accédez ensuite à l'adresse : [http://127.0.0.1:8000]()

---

## 💡 Notes importantes

* **Design :** Si le design ne s'affiche pas (pas de CSS), vérifiez que vous avez bien le dossier `public/css`.
* **Erreurs :** En cas d'erreur de connexion à la base de données, vérifiez bien le port (3306 pour XAMPP, 8889 pour MAMP).