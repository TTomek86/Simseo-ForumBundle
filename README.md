Simseo/ForumBundle
-----------------

Ce bundle est actuellement en developpement. Pour ceux qui voudraient contribuer, merci de faire une pull request sur Github. 

Installation
------------

Ce bundle a besoin d'utiliser knplabs/knp-paginator-bundle, stof/doctrine-extensions-bundle et egeloen/ckeditor-bundle. Je vous renvoie à leur propre documentation pour leur installation.

Utilisez composer pour gérer les dépendances et télécharger SimseoForumBundle

    $php composer.phar require simseo/forum-bundle


Enregistrez le bundle dans app/AppKernel.php

    $bundles = array(
        //---
        new Simseo\ForumBundle\SimseoForumBundle(),
    );

Ajoutez la configuration suivante dans app/config/config.yml

    simseo_forum:
        antiflood:
            enabled: true
            hours: 12 
        preview:
            enabled: true
        pagination:
            page_name: page
            topics:
                enabled: true
                per_page: 5
            posts: 
                enabled: true
                per_page: 5
        sonata_admin:
            enabled: false # passez cette option à true si vous utilisez SonataAdminBundle

Ajoutez un ROLE_MODERATOR dans app/config/security.yml

    security:
        role_hierarchy:
            ROLE_ADMIN:       [ROLE_MODERATOR]
            ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
            ROLE_MODERATOR:   [ROLE_USER]