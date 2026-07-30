<?php

namespace User\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use User\Event\UserCreatedEvent;

class UserCreatedListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onUserCreated',
        ];
    }

    public function onUserCreated(UserCreatedEvent $event): void
    {
        sprintf(
            'berhasil hit! datanya: %s',
            json_encode($event->getUser())
        );
    }
}
