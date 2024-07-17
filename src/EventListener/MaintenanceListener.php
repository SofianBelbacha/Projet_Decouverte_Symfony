<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;  // Utilisation de la classe Environment correcte
use Symfony\Component\HttpFoundation\Response;  // Utilisation de la classe Response correcte

final class MaintenanceListener
{
    public const IS_MAINTENANCE = false;
    public function __construct(private readonly Environment $twig)
    {
    }

    #[AsEventListener(event: KernelEvents::REQUEST, priority: 2000)]
    public function onKernelRequest(RequestEvent $event): void
    {
        if (self::IS_MAINTENANCE){
            $response = new Response($this->twig->render('maintenance.html.twig'));
            $event->setResponse($response);
        }
    }
}
