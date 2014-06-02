OVE - Bundle Symfony Thésaurus
===============

## Fonctionnalités


Application pour gérer des thésaurus et utilisable via des webservices

L'application elle-même utilsable ses propres webservices pour consulter et gérer ses thésaurus

## Pré-requis

Installer Syùfony et le Bundel d'authentification : 
  * https://github.com/tonygalmiche/AuthentificationBundle

G

https://thesaurus.fondation-ove.fr/app_dev.php/?id=2

 vim composer.json 
 3032  2014-06-02 : 12:05:58 : composer.phar update
 3033  2014-06-02 : 12:06:01 : vim composer.json 
 3034  2014-06-02 : 12:06:09 : composer.phar update
 3035  2014-06-02 : 12:07:05 : vim app/AppKernel.php 
 3036  2014-06-02 : 12:07:48 : cache_clear.sh 
 3037  2014-06-02 : 12:07:54 : php app/console router:debug
 3038  2014-06-02 : 12:08:04 : php app/console doctrine:schema:update --dump-sql
 3039  2014-06-02 : 12:08:15 : php app/console doctrine:schema:update --force
 3040  2014-06-02 : 12:08:37 : vim app/config/routing.yml 
 3041  2014-06-02 : 12:09:42 : php app/console router:debug
 3042  2014-06-02 : 12:10:09 : vim vendor/ove/thesaurus-bundle/OVE/ThesaurusBundle/Resources/config/routing.yml 
 3043  2014-06-02 : 12:10:33 : vim app/AppKernel.php 
 3044  2014-06-02 : 12:10:43 : vim app/config/routing.yml 
 3045  2014-06-02 : 12:11:08 : vim ../symfony_demo/app/config/routing.yml 
 3046  2014-06-02 : 12:11:16 : vim app/config/routing.yml 
 3047  2014-06-02 : 12:11:43 : php app/console router:debug
 3048  2014-06-02 : 12:11:48 : cache_clear.sh 
 3049  2014-06-02 : 12:12:30 : vim app/config/parameters.yml
 3050  2014-06-02 : 12:12:52 : vim ../symfony_demo/app/config/parameters.yml
 3051  2014-06-02 : 12:12:59 : vim app/config/parameters.yml
 3052  2014-06-02 : 12:14:23 : php app/console assets:install web --symlink
 3053  2014-06-02 : 14:04:33 : history 
