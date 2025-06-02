\\ Data base
CREATE DATABASE gestion_reclamations;

USE gestion_reclamations;

CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('client', 'support') NOT NULL
);

CREATE TABLE reclamations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    priorite ENUM('faible', 'moyenne', 'haute') NOT NULL,
    statut ENUM('ouverte', 'en cours', 'résolue') DEFAULT 'ouverte'
);

INSERT INTO utilisateurs (username, password, role) VALUES
('admin', MD5('admin'), 'support'),
('client', MD5('client'), 'client');

\\
# Système de Gestion des Réclamations

Ce projet est une application web de gestion des réclamations développée en PHP. Il permet aux utilisateurs de soumettre des réclamations et aux administrateurs de les gérer efficacement.

## Fonctionnalités

- Interface utilisateur pour soumettre des réclamations
- Panneau d'administration pour gérer les réclamations
- Système d'authentification des utilisateurs
- Statistiques et tableaux de bord
- Gestion des utilisateurs

## Prérequis

- PHP 7.0 ou supérieur
- MySQL/MariaDB
- Serveur web (Apache/Nginx)
- WAMP (Windows) / LAMP (Linux) / MAMP (Mac)

## Installation

1. Clonez ce dépôt dans votre répertoire web :
```bash
git clone [URL_DU_REPO]
```

2. Importez la base de données :
   - Ouvrez phpMyAdmin
   - Créez une nouvelle base de données
   - Importez le fichier `database.Sql`

3. Configurez la connexion à la base de données :
   - Modifiez le fichier `db.php` avec vos paramètres de connexion

4. Assurez-vous que votre serveur web pointe vers le répertoire du projet

## Structure du Projet

- `index.php` - Page d'accueil et authentification
- `formulaire.php` - Formulaire de soumission des réclamations
- `admin.php` - Interface d'administration
- `add_user.php` - Gestion des utilisateurs
- `stats.php` - Statistiques et rapports
- `logout.php` - Déconnexion
- `db.php` - Configuration de la base de données
- `database.Sql` - Structure de la base de données

## Utilisation

1. Accédez à l'application via votre navigateur
2. Connectez-vous avec vos identifiants
3. Pour les utilisateurs :
   - Soumettez une nouvelle réclamation via le formulaire
   - Consultez l'état de vos réclamations
4. Pour les administrateurs :
   - Gérez les réclamations
   - Consultez les statistiques
   - Gérez les utilisateurs

## Sécurité

- Les mots de passe sont hachés
- Protection contre les injections SQL
- Gestion des sessions sécurisée

## Support

Pour toute question ou problème, veuillez créer une issue dans le dépôt GitHub.

## Licence

Ce projet est sous licence MIT.
