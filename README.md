OVE - Bundle Symfony Thésaurus
===============

## Fonctionnalités


Application pour gérer des thésaurus et utilisable via des webservices

L'application elle-même utilise ses propres webservices pour consulter et gérer ses thésaurus

## Pré-requis

Installer Symfony et le Bundle d'authentification : 
  * https://github.com/tonygalmiche/AuthentificationBundle


## Installation

Ajouter cette lige

Ajouter cette ligne dans la section require de composer.json :

cd symfony
vim composer.json
    "require": {
        ...
        "ove/thesaurus-bundle": "dev-master"


Installer le Bundle avec composer :

    composer.phar update


Activer le Bundle en ajoutant cette ligne dans l'array des bundle :

   vim app/AppKernel.php
   $bundles = array(
      ...
      new OVE\ThesaurusBundle\OVEThesaurusBundle(),


Mettre en place les assets :

    php app/console assets:install web --symlink


Initialiser les tables de la base de données :

    php app/console doctrine:schema:update --dump-sql
    php app/console doctrine:schema:update --force


Mettre en place le routage : 

    vim app/config/routing.yml
    ove_thesaurus:
        resource: "@OVEThesaurusBundle/Resources/config/routing.yml"
        prefix:   /

Vérifier le fonctionnement du routage : 

    php app/console router:debug


Vider le cache :

    app/console cache:clear





