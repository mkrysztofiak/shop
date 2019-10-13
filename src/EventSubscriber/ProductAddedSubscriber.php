<?php

namespace App\EventSubscriber;

use App\Event\ProductAddedEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductAddedSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function onProductAdded(ProductAddedEvent $event)
    {
        $this->mailer->sendSimpleTextEmail(
            'mateusz@example.com',
            'fake@example.com',
            'Product added',
            sprintf('Product "%s" is added!', $event->getProduct()->getName())
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            ProductAddedEvent::class => 'onProductAdded',
        ];
    }
}
