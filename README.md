# Système de Gestion de Bibliothèque (Laravel 8)

Bienvenue sur le dépôt du projet de gestion de bibliothèque. Ce projet utilise **Laravel 8** avec le package **Breeze** pour l'authentification et **Tailwind CSS** pour le design.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

* **PHP** (8.0 ou supérieur)
* **MySQL** (via XAMPP, Laragon ou MAMP)
* **Composer**
* **Node.js & NPM**

---

##  Installation Rapide (Local)

1. **Cloner le projet**
```bash
git clone [LIEN_DE_TON_REPO_GITHUB]
cd Gestion-biblio

```


2. **Installer les dépendances PHP**
```bash
composer install

```


3. **Configuration de la Base de Données**
* Créez une base de données nommée `gestion_biblio` dans votre PHPMyAdmin.
* Copiez le fichier d'exemple : `cp .env.example .env`
* Modifiez votre fichier `.env` avec vos accès locaux :
```env
DB_DATABASE=gestion_biblio
DB_USERNAME=root
DB_PASSWORD= (vide ou 'root')

```




4. **Initialisation**
```bash
php artisan key:generate
php artisan migrate

```


5. **Lancer le serveur**
```bash
php artisan serve

```


Accédez au projet sur : [http://127.0.0.1:8000]()

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

* **AVANT DE COMMENCER N'OUBLIER PAS :** Faites toujours un `git fetch ` puis ` git  pull`. Si vous travaillez sur une version périmée, vous allez créer des erreurs lors de l'upload.
* **MIGRATIONS :** Si un collègue a ajouté une nouvelle table, vous verrez un nouveau fichier dans `database/migrations/`. Tapez impérativement `php artisan migrate` sur votre PC pour mettre à jour votre base de données locale.
* **FICHIERS INTERDITS SUR LE DRIVE !!! :**
* Ne jamais uploader le dossier `vendor/` ou `node_modules/`.
* Ne jamais remplacer le fichier `.env` (gardez votre config locale).


* **FICHIERS PARTAGÉS :** Pour les fichiers communs comme `routes/web.php` ou le design global, prévenez sur le groupe WhatsApp avant de les remplacer sur le Drive pour éviter d'écraser le travail d'un autre.

---