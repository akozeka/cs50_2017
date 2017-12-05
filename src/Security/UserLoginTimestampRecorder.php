<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\RememberMeToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class UserLoginTimestampRecorder implements EventSubscriberInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return [SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin'];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $token = $event->getAuthenticationToken();
        if ((!$token instanceof UsernamePasswordToken) && (!$token instanceof RememberMeToken)) {
            throw new \RuntimeException(
                'Authentication token must be '.UsernamePasswordToken::class.' or '.
                RememberMeToken::class.' instance!'
            );
        }

        $user = $token->getUser();
        if ($user instanceof User) {
            $user->recordLastLoggedAt();
            $this->manager->flush();
        }
    }
}
