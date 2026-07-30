<?php

namespace User\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event
{
    public function __construct(private array $user)
    {
    }

    public function getUser(): array
    {
        return $this->user;
    }
}
