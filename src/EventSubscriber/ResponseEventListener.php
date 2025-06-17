<?php

namespace ItkDev\TidyFeedbackBundle\EventSubscriber;

use Psr\Http\Message\ResponseFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;
use TwigCsFixer\Standard\Twig;

class ResponseEventListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly Environment $twig,
    )
    {
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $contentType = $response->headers->get('content-type') ?? '';
        if (!str_starts_with($contentType, 'text/html')) {
            return;
        }

        try {
            $widget = $this->twig->render('@TidyFeedback/default/widget.html.twig', []);

            if ($content = $response->getContent()) {
                $content = preg_replace('~</body>~i', $widget . '$0', $content);
                $response->setContent($content);
            }
        } catch (\Throwable) {
            // Ignore all errors!
        }
    }


    public static function getSubscribedEvents()
{
 return [
     KernelEvents::RESPONSE => 'onKernelResponse',
 ];
}
}
