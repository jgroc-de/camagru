# Camagru
## Description: (nouvelle version)

[description](https://jgroc-de.github.io/camagru.html)

## Installation

PHP 7.2 ou supérier est nécessaire pour faire fonctionner ce site.
Pour installer le projet:
```
git clone git@github.com:jgroc-de/camagru.git && composer install
php -S localhost:8080
```
composer ne fut pas absolument utile fut un temps désormais lointain

le site est désormais accessible à l'adresse "localhost:8080/" dans votre navigateur
je conseille mailhog pour les tester les mails.

Pour faire fonctionner le site, il faut aussi une base mysql active et entrer les identifiants dans App/container.php
initialiser la base de donnée en entrant l'adresse "localhost:8080/setup" dans votre navigateur internet

## details technique

Le site est constitué de deux parties:
- le backend qui se comporte comme une sorte d'api rest
- le front qui est une autre tentative de framework js

Le site est ainsi une sorte d'api qui livre le front sur la route /.
Le front se charge ensuite de remplir le site en tapant sur les autres routes.

### backend PHP

Le backend est construit autour d'un microframework php naif respectant le pattern MVC pour fonctionner.
Le code de celui-ci se trouve dans le dossier Dumb.
Il est composé des fichiers:
- dumb.php qui est le corps du framework MVC
- patronus.php qui est le controller parent (dont les autres controllers héritent. En théorie, la composition, c'est mieux en objet mais bon…)
- BakaDo.php, le router (Do la voie, et baka…)
- IronWall.php, le gestionnaire de middleware respectant PSR-15 (pattern "chain of responsability")
- Response.php compatible PSR-7 (pattern "singleton")
- Request.php compatible PSR-7 (ébauche)

Ce framework permet de definir:
- des middlewares dans app/config/middleware.php (autant de couches que nécessaires)
- les routes possibles dans app/config/routes.php (avec de l'url rewriting tres basique)
- un systeme de container dans app/config/container.php
- un systeme de validation de formulaire dans app/config/forms.php

Le point d'entrée se trouve de manière classique dans index.php.
Enfin, une organisation pseudo REST est proposée avec l'utilisation des verbs HTTP comme méthodes des controllers.

### JS

Le front est à peu pret tout en JS, avec la navigation gérée par le trick du changement de hash (visible par le '#' dans l'adresse).
Dans le dossier public/js, vous trouverez app.js qui est le point d'entrée
et qui charge:
- app/anGGular.js, la class initiale qui charge les modules de bases 
- app/router.js, le router, chargé de définir la route
- middleware.js, le middleware.js qui sert nottamment à rediriger vers la page login les pages nécessitant d'etre identifié sur le site
- app/container.js, qui sert à construire le controller qui va bien en fonction de la route demandée
- AnGGular/controller.js, qui est donc le squellette de controller dont tout le monde dépend

Contrairement à la partie PHP, ce n'est pas une structure MVC. Nous avons ici un seul controller dont les parametres sont, en résumé:
- une classe event qui gére les events de la page (ou l'élément) visionnée
- une classe behavior, qui vient gérer la maniere dont l'élément réagit visiblement parlant en général
La logique n'est pas totalement finalisée au sens ou behavior fait un peu doublon avec event et les classes du dossier events pourraient etre refactorisée (pas mal de code dupliqué dans ce dossier)

Cela reste une tentative instructive de mon point de vue.


### Test du backend

Des test du backend existent à coup de curl dans le dossier curlTest.
Dans le dossier hooks, on trouve des hooks pour git pour tester le back au moment des push et éventuellement l'arreter si ceux ci échouent.

## evolution possible

### front
- passer par l'API history
- en faire une pwa

### back
- rajouter des objets images etc, et un ORM tant qu'a faire