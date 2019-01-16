# Camagru

## Description:

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
