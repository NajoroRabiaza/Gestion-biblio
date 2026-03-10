# Système de Gestion de Bibliothèque (Laravel 8)
Bienvenue sur le dépôt du projet de gestion de bibliothèque. Ce projet utilise **Laravel 8** avec le package **Breeze** pour l'authentification et **Tailwind CSS** pour le design.

## Prérequis
Avant de commencer, assurez-vous d'avoir installé :
* **PHP** (8.0 ou supérieur)
* **MySQL** (via XAMPP, Laragon ou MAMP)
* **Composer**
* **Node.js & NPM**

---

## Installation Rapide (Local)

1. **Cloner le projet**
```bash
git clone [LIEN_DE_CE_REPO_GITHUB_QUI_SOIT_DU_SSH_OU_HTTP]
cd Gestion-biblio
```

2. **Installer les dépendances PHP**
```bash
composer install
```
> 📦 *C'est quoi ?* Composer c'est le gestionnaire de paquets PHP. Cette commande lit le fichier `composer.json` et télécharge toutes les librairies PHP dont Laravel a besoin. Elle crée le dossier `vendor/`. Sans ça, rien ne marche.

3. **Installer les dépendances JavaScript**
```bash
npm install
```
> 📦 *C'est quoi ?* Pareil que Composer mais pour le JavaScript. Cette commande télécharge Tailwind CSS et tous les outils front-end. Elle crée le dossier `node_modules/`. À faire une seule fois.

4. **Configuration de la Base de Données**
* Créez une base de données nommée `gestion_biblio` dans votre PHPMyAdmin.
* Copiez le fichier d'exemple : `cp .env.example .env`
* Modifiez votre fichier `.env` avec vos accès locaux :
```env
DB_DATABASE=gestion_biblio
DB_USERNAME=root
DB_PASSWORD= (vide ou 'root')
```

5. **Initialisation**
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```
> ⚠️ Le `php artisan db:seed` est obligatoire ! Il insère les données de test dans la base de données (catégories, auteurs, livres, et comptes utilisateurs). Sans ça, l'application sera vide.

---

## Lancer le projet (à faire à chaque fois)

> ⚠️ Ces deux commandes sont à lancer **à chaque fois** que vous travaillez sur le projet. Il faut ouvrir **deux terminaux en même temps**.

**Terminal 1 — Le serveur PHP (backend)**
```bash
php artisan serve
```
> 🖥️ *C'est quoi ?* C'est le serveur local de Laravel. Il permet d'accéder au projet dans le navigateur sur `http://127.0.0.1:8000`. Sans cette commande, vous ne pouvez pas voir le site.

**Terminal 2 — Le compilateur CSS/JS (frontend)**
```bash
npm run dev
```
> 🎨 *C'est quoi ?* Cette commande compile le CSS Tailwind et le JavaScript du projet. Si vous ne la lancez pas, le design ne s'affichera pas — la page sera sans style, juste du texte brut. Laissez ce terminal ouvert pendant que vous travaillez.

---

## Comptes de test disponibles

Une fois le seeder lancé, vous pouvez vous connecter avec ces comptes :

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin (Bibliothécaire) | admin@biblio.com | password |
| Client (Membre) | client@biblio.com | password |

---

## État actuel du projet

| Étape | Description | Statut |
|---|---|---|
| Étape 5 | Installation Laravel + configuration .env | ✅ Terminé |
| Étape 6 | Migrations + Modèles Eloquent | ✅ Terminé |
| Étape 7 | Authentification Laravel Breeze | ✅ Terminé |
| Étape 6bis | Seeders (données de test) | ✅ Terminé |
| Étape 8 | Affichage catalogue livres | ✅ Terminé |
| Étape 9 | Mise en page et design | ✅ Terminé |
| Étape 10 | Formulaire ajout livre (Admin) | ✅ Terminé |
| Étape 12 | Système d'Emprunt (Client) | ⏳ À faire |
| Étape 13 | Mes Emprunts (Client) | ⏳ À faire |
| Étape 14 | Gestion des Retours (Admin) | ⏳ À faire |
| Étape 15 | Modifier et Supprimer un Livre (Admin) | ⏳ À faire |
| Étape 16 | Gestion des Auteurs et Catégories (Admin) | ⏳ À faire |
| Étape 17 | Tableau de Bord Admin (Statistiques) | ⏳ À faire |
| Étape 18 | Gestion des Membres (Admin) | ⏳ À faire |
| Étape 19 | Détection des Retards et Sanctions | ⏳ À faire |
| Étape 20 | Tests finaux et Nettoyage du Code | ⏳ À faire |

---

## Structure de la base de données

Le projet contient 6 tables :
* `users` — les membres et administrateurs
* `categories` — les catégories des livres
* `authors` — les auteurs des livres
* `books` — le catalogue des livres
* `borrowings` — les emprunts
* `sanctions` — les pénalités de retard

---

## 📋 PROTOCOLE DE TRAVAIL (Important)

Pour garantir une bonne note et assurer que le professeur voit l'activité de **chaque membre**, nous suivons strictement ce protocole hybride entre GitHub et le Drive.

### Le Cycle de Développement
À chaque fois que vous terminez une tâche ou un fichier :

1. **GITHUB (Le Code propre)** :
Faites un `git add`, `git commit` et `git push` de votre travail. C'est notre base de code officielle.

2. **DRIVE (La Preuve pour le prof)** :
Uploadez ou remplacez immédiatement les fichiers modifiés dans les dossiers correspondants sur Google Drive.
* *Pourquoi ?* Le professeur vérifie l'historique d'activité du Drive. En "remplaçant" le fichier, votre nom et l'heure de modification apparaissent.

3. **SHEET (Le Suivi)** :
Mettez à jour notre fichier Google Sheet en passant le statut de votre tâche de `EN COURS` à `TERMINÉ`.

---

### ⚠️ Règles de sécurité et de synchronisation

* **AVANT DE COMMENCER N'OUBLIER PAS :** Faites toujours un `git fetch` puis `git pull`. Si vous travaillez sur une version périmée, vous allez créer des erreurs lors de l'upload.

* **MIGRATIONS :** Si un collègue a ajouté une nouvelle migration, vous verrez un nouveau fichier dans `database/migrations/`. Tapez impérativement ces deux commandes sur votre PC :
```bash
php artisan migrate
php artisan db:seed
```
> ⚠️ Attention : si vous avez déjà des données dans votre base, le `db:seed` va dupliquer les données. Dans ce cas faites plutôt `php artisan migrate:fresh --seed` qui repart de zéro.

* **FICHIERS INTERDITS SUR LE DRIVE !!! :**
  * Ne jamais uploader le dossier `vendor/` ou `node_modules/`
  * Ne jamais remplacer le fichier `.env` (gardez votre config locale)

* **FICHIERS PARTAGÉS :** Pour les fichiers communs comme `routes/web.php` ou le design global, prévenez sur le groupe WhatsApp avant de les modifier pour éviter d'écraser le travail d'un autre.