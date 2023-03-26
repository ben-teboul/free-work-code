# Explication

Le code présent est un système conçu pour s'adapter à de nombreuses API différentes sans impacter notre système et sans dépendre des systèmes externes.<br />
Son objectif final est de pouvoir diffuser les informations relatives à une offre d'emploi sur divers sites d'annonces.

Chaque site d'annonce possède sa propre API avec des exigences spécifiques.<br />
Pour cette raison, chaque site d'annonce a sa propre classe contenant des méthodes précises :
- la première pour mettre en forme les données de l'offre d'emploi stockées dans notre base de données, 
- la deuxième pour envoyer ces données au site d'annonce correspondant,
- et la troisième pour récupérer et traiter la réponse de l'API, avant de la renvoyer à notre système.

Ce système présente plusieurs avantages :

- Il permet de ne pas dépendre des systèmes externes.
- Il permet de ne pas avoir à modifier notre système pour chaque site d'annonce.
- Dans le cas d'une erreur sur un site d'annonce, cela n'impacte pas les autres envois.
- Il est facilement maintenable.
- Il est facilement scalable.


# Lancement de l'application
### Pour lancer l'application, exécutez les commandes suivantes :

> docker-compose up -d

> docker-compose exec server composer install

### Ensuite, accédez à l'URL http://localhost:80