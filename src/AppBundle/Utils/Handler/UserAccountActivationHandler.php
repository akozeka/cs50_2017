<?php

namespace AppBundle\Utils\Handler;

use AppBundle\Entity\User;
use AppBundle\Entity\UserActivationToken;
use AppBundle\Security\AuthenticationUtils;
use Doctrine\Common\Persistence\ObjectManager;

class UserAccountActivationHandler
{
    private $manager;

    public function __construct(ObjectManager $manager) {
        $this->manager = $manager;
    }

    public function handle(User $user, UserActivationToken $token): void
    {
        $user->activate($token);
        $this->manager->flush();
    }
}
