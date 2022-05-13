# LMT-FORMATION
## La documentation d'installation du projet en mode développeur

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

## Installation

Sur votre serveur web installer la version 7.3 de [php](https://windows.php.net/download/) et prenez n'importe quelle version de [composer](https://getcomposer.org/download/).
De plus, prenez soin d'installer le bundle [symfony](https://symfony.com/download) au préalable.
Ensuite, dans le dossier où vous souhaiterez placer votre projet vous effectuerez les commandes suivantes :
```sh
$ git clone https://github.com/Custromix/lmt-formation-crud
$ cd lmt-formation-crud
$ composer install
$ symfony server:start
```

Il vous faudra récupérer le script de la base de donnée se trouvant dans : /config/script_bdd/script.sql.
> WARNING: le fichier .env permettant la connection à la base de donnée doit être configuré selon vos paramètres
[En savoir plus](https://symfony.com/doc/current/doctrine.html)
