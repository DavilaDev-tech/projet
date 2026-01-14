# biblio - Application de gestion de bibliothèque universitaire

##  Description
Application web en PHP/MySQL pour gérer les étudiants, les livres et les emprunts.

##  Installation
1. Importer `biblio.sql` dans phpMyAdmin pour créer la base de données.
2. Placer le dossier `biblio/` dans votre serveur local (XAMPP/Wamp/MAMP).
3. Configurer `app/db.php` avec vos identifiants MySQL.
4. Créer un utilisateur dans la table `Utilisateur` avec `password_hash()`.

##  Structure du projet
- `app/` : logique métier (connexion DB, contrôleurs, auth).
- `views/` : formulaires et layouts HTML.
- `public/` : pages accessibles par navigateur (index, login, CRUD).
- `uploads/` : fichiers uploadés (images de couverture).
- `assets/` : CSS, JS, images statiques.
- `biblio.sql` : script SQL de création de la base.
- `README.md` : documentation du projet.

##  Utilisation
- Connectez-vous via `login.php`.
- Accédez au tableau de bord (`index.php`).
- Gérez les étudiants, livres et emprunts via les pages dédiées.
- Upload d’images de couverture via `upload.php`.

##  Technologies
- PHP 8+
- MySQL/MariaDB
- Bootstrap 5
- JavaScript (validation, animations)

##  Auteurs
Projet réalisé par 
Davila : 
-Coordination générale du projet. 
-Rédaction de la présentation de l'application et des objectifs.
-Gestion du depot gitHub : création du depot, invitations et vérification des contributions.
-Intégration et tests des differentes fonctionnalités.

Yvan : 
-Conception de la table "Etudiant".
-Implémentation de l'interface pour la gestion des étudiants(ajouter,modifier,supprimer)
-Ecriture des requetes pour les étudiants.
-Vérification de session pour les pages liés aux étudiants.

Fresnel :
-Conception de la table "Livre".
-Implémentation de l'interface pour la gestion des livres(ajouter,modifier,supprimer)
-Ecriture des requetes pour les livres.
-Gestion du téléchargement de fichiers.

Kevine :
-Conception de la table "Emprunter" et "Utilisateur".
-Implémentation de l'interface pour la gestion des emprunts et des utilisateurs(Authentification,gestion de session).
-Ecriture des requetes pour gérer les emprunts et les connexions.
-Intégration de la gestion des sessions utilisateur sur toutes les pages requises.
