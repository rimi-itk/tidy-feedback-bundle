<?php

namespace ItkDev\TidyFeedbackBundle;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class EntityManagerFactory
{
    private static EntityManager $instance;

    public static function getEntityManager(): EntityManager
    {
        if (!isset(self::$instance)) {
            // https://www.doctrine-project.org/projects/doctrine-orm/en/3.4/tutorials/getting-started.html#getting-started-with-doctrine
            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [dirname(__DIR__) . '/src'],
                isDevMode: true,
            );

            $connection = DriverManager::getConnection([
                'driver' => 'pdo_sqlite',
                'path' => __DIR__ . '/db.sqlite',
            ], $config);

            self::$instance = new EntityManager($connection, $config);
        }

        return self::$instance;
    }
}
