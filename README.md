# Camagru
## Description: (nouvelle version)

Petit site type instagram en php/js brut.

## Installation

Pour installer le projet:
```
git clone git@github.com:jgroc-de/camagru.git && composer install && php -S localhost:8000 -t public
```
composer sert ici à initialiser l autoloader. Le site est accessible a l'adresse http:\\localhost:8000

## details technique

Le site utilise une sorte de microframework php naif pour fonctionner.
Le code de celui-ci se trouve dans le dossier Dumb.
Il est composé de deux fichiers:
- dumb.php qui est le corps du framework
- patronus.php qui est le controller parent

Ce framework permet de definir:
- un middleware dans app/config/middleware.php
- un validateur de formulaire dans app/config/form.php
- une troisieme couche de securité dans app/config/ghost.php
- les routes possibles dans app/config/routes.php (avec de l'url rewriting tres basique)
- un systeme de container dans app/container.php

le point d'entrée se trouve de manière classique dans public/index.php
enfin, une organisation pseudo REST est proposée avec l'utilisation des verbs HTTP comme methodes des controller.
le site est ainsi une sorte d'api qui livre le front sur la route /.
le front se charge ensuite de remplir le site en tapant sur les autres routes.

## evolution en cours

- faire du js propre
- en faire une pwa

## Description: (ancienne version)

  Vous allez devoir réaliser, en PHP, un petit site Instagram-like permettant à des utilisateurs de réaliser et partager des photo-montages. Vous allez ainsi implémenter, à mains nues (les frameworks sont interdits), les fonctionnalités de base rencontrées sur la majorité des sites possédant une base utilisateur
![screenshot](/assets/camagru2.png)

## Objectif pédagogique:
  
  - Gestion utilisateurs
  - Gestion permissions
  - Mailing
  - Sécurité / Validation de données
  
![screenshot](/assets/camagru1.png)

## Langages:

| Back-end | Front-end | bdd |
|---|---|---|
| PHP | HTML5, CSS3, *VanillaJS* | MySQL |
  
## Contraintes techniques:

  Pas de framework;
  
  ```php
  <?='Hello Worldl!'?>
  ```
  
## Utilisation

Pour lancer ce site, il vous faut un service/server mysql actif, et php 5.4 ou supérieur.

- dans un terminal, entrer: "git clone https://github.com/jgroc-de/camagru.git"
- dans le dossier camagru tout juste créé, aller dans config/database.php et modifier le mot de passe pour permettre l'acces à votre base de donnée mysql (et éventuellement le nom d'utilisateur si vous n'etes pas "root")
- placer vous à la racine du dossier 'camagru' et entrez la commande "php -S localhost:8080". un serveur est maintenant lancé en local.
- initialiser la base de donnée en entrant l'adresse "localhost:8080/config/setup.php" dans votre navigateur internet (firefox/chrome/safari)
- le site est désormais opérationnel et accessible à l'adresse "localhost:8080/". faites chauffer votre webcam!
![screenshot](/assets/camagru0.png)
