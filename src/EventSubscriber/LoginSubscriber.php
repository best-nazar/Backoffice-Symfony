<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
        ];
    }

    public function onCheckPassport(CheckPassportEvent $event): void
    {
        /** @var App\Entity\User $user */
        $user = $event->getPassport()->getUser();

        if ($user->getIsActive() === 0) {
            throw new CustomUserMessageAuthenticationException(
                'User is not active. Please activate your account before logging in.'
            );
        }
    }
}
