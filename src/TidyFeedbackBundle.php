<?php

namespace ItkDev\TidyFeedbackBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class TidyFeedbackBundle extends AbstractBundle implements CompilerPassInterface
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

// I can't get `implements CompilerPassInterface` to work …
        $container->addCompilerPass(new class () implements CompilerPassInterface {
            public function process(ContainerBuilder $container): void
            {
                return;
                if ($container->has('doctrine')) {
                    /** @var Registry $registry */
                    $registry = $container->get('doctrine');
                    $registry->getManagerForClass(get_class($container));
                    header('content-type: text/plain');
                    echo var_export(null, true);
                    die(__FILE__ . ':' . __LINE__ . ':' . __METHOD__);
                    // TODO: Implement process() method.
                }
            }
        });
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');
    }

// https://symfony.com/doc/current/service_container/compiler_passes.html#working-with-compiler-passes-in-bundles
    public function process(ContainerBuilder $container): void
    {
//        header('content-type: text/plain'); echo var_export(null, true); die(__FILE__.':'.__LINE__.':'.__METHOD__);
        // TODO: Implement process() method.
    }
}
