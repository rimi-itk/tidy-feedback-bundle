<?php

use ItkDev\TidyFeedbackBundle\Controller\FeedbackController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('tidy_feedback_index', '/')
        // the controller value has the format [controller_class, method_name]
        ->controller([FeedbackController::class, 'index'])
        ->methods([Request::METHOD_GET]);

    $routes->add('tidy_feedback_new', '/new')
        ->controller([FeedbackController::class, 'new'])
        ->methods([Request::METHOD_GET, Request::METHOD_POST]);

    $routes->add('tidy_feedback_widget', '/widget')
        ->controller([FeedbackController::class, 'widget'])
        ->methods([Request::METHOD_GET]);

    $routes->add('tidy_feedback_create', '/')
        ->controller([FeedbackController::class, 'create'])
        ->methods([Request::METHOD_POST]);

    $routes->add('tidy_feedback_show', '/{item}')
        ->controller([FeedbackController::class, 'show'])
        ->methods([Request::METHOD_GET]);

};
