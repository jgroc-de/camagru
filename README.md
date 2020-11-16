# Camagru
## Description: (nouvelle version)

Petit site type instagram en php/js brut visible [ici](https://camagru42.herokuapp.com/).
![screenshot](/assets/camagruV2_0.png)

## Objectif pédagogique:
  
  - Gestion utilisateurs
  - Gestion permissions
  - Mailing
  - Sécurité / Validation de données
 

## Langages:

| Back-end | Front-end | bdd |
|---|---|---|
| PHP 7.2 | HTML5, CSS3 (w3-css), *VanillaJS* | MySQL 5.7 |
  
## Contraintes techniques:

  Pas de framework;
  
  ```php
  <?= 'Hello Worldl!' ?>
  ```
  
## Installation

PHP 7.0 ou supérier est nécessaire pour faire fonctionner ce site.
Pour installer le projet:
```
git clone git@github.com:jgroc-de/camagru.git && composer install
php -S localhost:8080
```
composer ne fut pas absolument utile fut un temps

le site est désormais accessible à l'adresse "localhost:8080/" dans votre navigateur

Pour faire fonctionner le site, il faut aussi une base mysql active et entrer les identifiants dans App/container.php
initialiser la base de donnée en entrant l'adresse "localhost:8080/config/setup.php" dans votre navigateur internet

![screenshot](/assets/camagruV2_1.png)

## details technique

### PHP

Le site utilise une sorte de microframework php naif pour fonctionner.
Le code de celui-ci se trouve dans le dossier Dumb.
Il est composé des fichiers:
- dumb.php qui est le corps du framework
- patronus.php qui est le controller parent (dont les autres controllers héritent. En théorie, la composition, c'est mieux en objet mais bon…)
- BakaDo.php, le router
- IronWall.php, le gestionnaire de middleware respectant PSR-15 construit en suivant le pattern "chain of responsability"
- Response.php compatible PSR-7
- Request.php compatible PSR-7

Ce framework permet de definir:
- des middlewares dans app/config/middleware.php (autant de couches que nécessaires)
- les routes possibles dans app/config/routes.php (avec de l'url rewriting tres basique)
- un systeme de container dans app/config/container.php
- un systeme de validation de formulaire dans app/config/forms.php

le point d'entrée se trouve de manière classique dans index.php
enfin, une organisation pseudo REST est proposée avec l'utilisation des verbs HTTP comme methodes des controller.
le site est ainsi une sorte d'api qui livre le front sur la route /.
le front se charge ensuite de remplir le site en tapant sur les autres routes.

### JS

Le front est à peu pret tout en JS, avec la navigation gérée par le changement de hash (visible par le '#' dans l'adresse).
Dans le dossier public/js, vous trouverez app.js qui est le point d'entrée
et qui charge:
- app/anGGular.js, la class initiale qui charge les modules de bases 
- app/router.js, le router, chargé de définir la route
- middleware.js, le middleware.js qui sert nottamment à rediriger vers la page login les pages nécessitant d'etre idetifié sur le site
- app/container.js, qui sert à construire le controller qui va bien en fonction de la route demandée
- AnGGular/controller.js, qui est donc le squellette de controller dont tout le monde dépend

Contrairement à la partie PHP, ce n'est pas une structure MVC. Nous avons ici un seul controller dont les parametres sont, en résumé:
- une classe event qui gére les events de la page (ou l'élément) visionnée
- une classe behavior, qui vient gérer la maniere dont l'élément réagit visiblement parlant en général
La logique n'est pas totalement finalisée au sens ou behavior fait un peu doublon avec event et les classes du dossier events pourraient etre refactorisée (pas mal de code dupliqué dans ce dossier)

Cela reste une tentative instructive de mon point de vue.

## evolution en cours

- en faire une pwa

## evolution possible

- faire du js propre (trollolol)

![screenshot](/assets/camagruV2_2.png)
