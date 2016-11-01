# Installation de l'application

Guide d'installation de l'application

## Homestead

Suivre la documentation d'installation de la homestead sur le site [Laravel](https://laravel.com/docs/5.3/homestead).

Ajouter la ligne "mariadb: true" dans le fichier homestead.yaml.

Générer une clé ssh au besoin comme ceci :
```
ssh-keygen -t rsa -C "youremail@yourdomain".
```

## Mise en place du projet
Installation des dépendances avec composer
```
composer install
```

Réaliser une copie de .env.example et le coller à la racine sous le nom de .env.
Configurer ensuite le fichier pour qu'il fonctionne sur votre environnement.

## Mise en place de la base de données
Ajouter les tables nécessaires au fonctionnement de l'application dans la base données

```
php artisan migrate
```

Ajouter les données nécessaires (seeds) au fonctionnement de l'application

```
php artisan db:seed
```

## Administion de l'application
L'administrateur par défaut est "admin@consumerlab.com".
Son password est "admin".
L'administration est disponible à partir de l'url "/admin".

Un administrateur peut créer/modifier/supprimer un questionnaire.
Un questionnaire est composé de questions qui sont elles-même composées de choix de réponse.
L'administrateur peut également consulter les statistiques de réponse.
