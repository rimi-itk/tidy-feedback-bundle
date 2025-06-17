<?php

namespace ItkDev\TidyFeedbackBundle\Command;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use ItkDev\TidyFeedbackBundle\EntityManagerFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'tidy-feedback:stuff')]
class DbCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
//        https://www.doctrine-project.org/projects/doctrine-orm/en/3.4/tutorials/getting-started.html#generating-the-database-schema
        $provider = new SingleManagerProvider(EntityManagerFactory::getEntityManager());
//        ConsoleRunner::run($provider);

        return static::SUCCESS;
    }

}
