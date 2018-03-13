Licence Pro DIM - Projet Symfony - ShowRoom
==================================

## Requierement

* Composer 
* Php 7 ou plus

## Installation

> TODO : Se positionner en fonction du lieu où l'on souhaite avoir son projet

> Commande bash : cd Path\to\my\project
```bash
git clone https://github.com/cavasinf/symfonyGobelins.git
cd symfonyGobelins
composer install
php bin/console assets:install
```
> TODO : Configurer en fonction de vos besoins (ip, port, ...)
```bash
php bin/console d:d:c
php bin/console s:r
```

## Création du premier l'utilisateur admin

> Afin de pouvoir acceder au service un compte admin principale est nécessaire, pour cela il vous faut le créer dans votre BDD dans la table 'user'.
> Il vous faut generer un mot de passe hashé grace à l'API avec l'adresse suivante :
```
http://127.0.0.1:8000/api/user/createPassword/VotreMotDePasseIci

Valeur de retour : "$2y$13$S0g0CY6IEFHdGjkBPt2ZH.Ki0iqBHcxUSSO6.bi2liZaoaWIsc1hm"
```
> Ensuite définir un role ADMIN pour cet utilisateur, en écrivant ceci dans la colonne 'roles' de la table **user**
```
["ROLE_ADMIN"]
```

## Temps de travail

Jour|Date|Temps
--- | --- | ---
Lundi | 05/02 | (2h)
Mardi | 06/02 | (7h)
Dimanche | 11/02 | (4H)
Lundi | 12/02 | (6,5H)
Mardi | 13/03 | (4H)
--- |**Total**| **24H**


>Intervenante : Sarah KHALIL
