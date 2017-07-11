Simseo/ForumBundle
-----------------

Ce bundle est actuellement en developpement. Pour ceux qui voudraient contribuer, merci de faire une pull request sur Github. 

Installation
------------

Ce bundle a besoin d'utiliser knplabs/knp-paginator-bundle, stof/doctrine-extensions-bundle et egeloen/ckeditor-bundle. Je vous renvoie à leur propre documentation pour leur installation.

Utilisez composer pour gérer les dépendances et télécharger SimseoForumBundle

```bash
    $php composer.phar require simseo/forum-bundle
```

Enregistrez le bundle dans app/AppKernel.php
```php
    <?php
    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Simseo\ForumBundle\SimseoForumBundle(),
        );
        // ...
    }
```

Ajoutez les routes:

```yaml

    # app/config/routing.yml

    simseo_forum:
    resource: "@SimseoForumBundle/Resources/config/routing.yml"
    prefix:   /forum
```
Ajoutez la configuration suivante dans app/config/config.yml

```yaml
    # app/config/config.yml
    
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
```

Ajoutez un ROLE_MODERATOR dans app/config/security.yml

```yaml
    # app/config/security.yml

    security:
        role_hierarchy:
            ROLE_ADMIN:       [ROLE_MODERATOR]
            ROLE_SUPER_ADMIN: [ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]
            ROLE_MODERATOR:   [ROLE_USER]
```

Configuration

```yaml
    # app/config/config.yml

    doctrine:
        orm:
            auto_generate_proxy_classes: '%kernel.debug%'
            naming_strategy: doctrine.orm.naming_strategy.underscore
            auto_mapping: true
            resolve_target_entities:
                Symfony\Component\Security\Core\User\UserInterface: Namespace\YourUserBundle\Entity\User
                Sonata\MediaBundle\Model\MediaInterface: NameSpace\YourMediaBundle\Entity\Media

    # StofDoctrineExtentions Configuration
    stof_doctrine_extensions:
        orm:
            default:
                sluggable: true
                timestampable: true
                blameable: true
                sortable: true

    knp_paginator:
        page_range: 5
        default_options:
            page_name: page
            sort_field_name: sort
            sort_direction_name: direction
            distinct: true
        template:
            pagination: 'KnpPaginatorBundle:Pagination:sliding.html.twig'
            sortable: 'KnpPaginatorBundle:Pagination:sortable_link.html.twig'

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
            enabled: false
```

Mettez à jour la base de donnée

    $ php app/console doctrine:schema:update --force

Rendez vous ensuite à l'adresse /forum/admin et créez vos premiers forums. 