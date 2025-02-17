# EcoRide

## A propos

EcoRide est une application fictive de covoiturage qui prône des valeurs écologiques.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :
- un serveur PHP comme [Xampp](https://www.apachefriends.org/index.html), Mampp ou Wampp
- [Node.js](https://nodejs.org/fr) (pour les paquets npm si nécessaire),
- un SGBD comme [phpMyAdmin](https://www.phpmyadmin.net/) pour gérer votre base de données,
- une version récente de [PHP](https://www.php.net/)

## Technologies utilisées

- **HTML5** : structure du contenu
- **CSS3** : stylisation et mise en page
- **Bootstrap 5** : mise en page responsive
- **JavaScript** : intéractivité
- **PHP 8.2.12** : langage de programmation serveur
- **MySQL** : base de données relationnelles
- **Alwaysdata** hébergeur de bases de données
- **Xampp** : environnement de développement web
- **VScode** : éditeur de code source

## Installation

### Télécharger et extraire le projet

- sur le repository du projet EcoRide, cliquez sur le bouton "code" puis télécharger le zip
- extraire le fichier ZIP dans un répertoire de votre machine

### Importer la base de données

- Ouvrez votre outil de gestion de base de données (comme phpMyAdmin)
- Créez une nouvelle base de données pour EcoRide
- Importez la base de données en exécutant le script SQL situé dans le répertoire du projet (burgos_ecoride.sql)

### Configurer la connexion à la base de données

- dans le fichier config.php situé dans le dossier lib, mettez à jour les paramètres de connexion à la base de données pour correspondre à votre environnement local :
+ host : le nom d'hôte de votre serveur MySQL
+ dbname : le nom de votre base de données
+ username : votre nom d'utilisateur
+ password : le mot de passe à utiliser pour la connexion à la base de données

### Installer votre serveur PHP

- Ouvrez votre serveur PHP (Xampp, Mampp ou autre), lancez Apache et MySQL
- Ouvrez le projet en tapant [http://localhost/nom_de_votre_dossier] dans votre navigateur web