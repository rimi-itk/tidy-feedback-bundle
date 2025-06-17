# Tidy feedback

## Installation

``` shell
composer require itk-dev/tidy-feedback-bundle
```

``` yaml
#config/routes/tidy_feedback.yaml
tidy_feedback:
    resource: "@TidyFeedbackBundle/config/routes.php"
    prefix: /tidy_feedback
```

Add a connection for Tidy feedback (cf. [How to Work with Multiple Entity Managers and
Connections](https://symfony.com/doc/current/doctrine/multiple_entity_managers.html)), e.g. change

``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        url: "%env(resolve:DATABASE_URL)%"
        server_version: "5.7"
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci
        types:
            SmileyType: App\DBAL\Types\SmileyType
        # IMPORTANT: You MUST configure your server version,
        # either here or in the DATABASE_URL env var (see .env file)
        #server_version: '16'
        use_savepoints: true
    orm:
        auto_generate_proxy_classes: true
        enable_lazy_ghost_objects: true
        naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
        auto_mapping: true
        mappings:
            App:
                is_bundle: false
                dir: "%kernel.project_dir%/src/Entity"
                prefix: 'App\Entity'
                alias: App
            GedmoLoggable:
                prefix: Gedmo\Loggable\Entity
                dir: "%kernel.project_dir%/vendor/gedmo/doctrine-extensions/src/Loggable/Entity"
                is_bundle: false
        filters:
            entity_active:
                class: App\Doctrine\EntityActiveFilter
                enabled: true

```

to

``` yaml
# config/packages/doctrine.yaml
doctrine:
    dbal:
        connections:
            default:
                url: "%env(resolve:DATABASE_URL)%"
                server_version: "5.7"
                charset: utf8mb4
                default_table_options:
                    charset: utf8mb4
                    collate: utf8mb4_unicode_ci
                # IMPORTANT: You MUST configure your server version,
                # either here or in the DATABASE_URL env var (see .env file)
                #server_version: '16'
                use_savepoints: true
            tidy_feedback:
                url: 'sqlite:///%kernel.project_dir%/var/tidy_feedback.db'
        types:
            SmileyType: App\DBAL\Types\SmileyType
        default_connection: default
    orm:
        default_entity_manager: default
        auto_generate_proxy_classes: true
        enable_lazy_ghost_objects: true
        entity_managers:
            default:
                connection: default
                naming_strategy: doctrine.orm.naming_strategy.underscore_number_aware
                auto_mapping: true
                mappings:
                    App:
                        is_bundle: false
                        dir: "%kernel.project_dir%/src/Entity"
                        prefix: 'App\Entity'
                        alias: App
                    GedmoLoggable:
                        prefix: Gedmo\Loggable\Entity
                        dir: "%kernel.project_dir%/vendor/gedmo/doctrine-extensions/src/Loggable/Entity"
                        is_bundle: false
                filters:
                    entity_active:
                        class: App\Doctrine\EntityActiveFilter
                        enabled: true
            tidy_feedback:
                connection: tidy_feedback
                mappings:
                    TidyFeedbackBundle:
                        dir: "%kernel.project_dir%/vendor/itk-dev/tidy-feedback-bundle/src/Entity"
                        prefix: 'ItkDev\TidyFeedbackBundle\Entity'
```

If [Symfony Flex](https://symfony.com/doc/current/setup/flex.html) hasn't already done so, you must enable the
TidyFeedbackBundle bundle:

``` php
// config/bundles.php
return [
    …,
    ItkDev\TidyFeedbackBundle\TidyFeedbackBundle::class => ['all' => true],
];
```

``` shell
bin/console doctrine:database:create --connection=tidy_feedback
bin/console doctrine:schema:validate --em=tidy_feedback
bin/console doctrine:schema:update --em=tidy_feedback --complete --force --dump-sql
```

``` shell
curl "http://$(docker compose port nginx 8080)/tidy_feedback/" --header 'content-type: application/json' --data '{"subject": "My first feedback"}'
```
