<?php

namespace AppBundle\Utils\Handler;

use AppBundle\Entity\PostAddressEmbeddable;
use AppBundle\Entity\User;
use AppBundle\Entity\UserActivationToken;
use AppBundle\Events;
use AppBundle\Utils\Registration;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationHandler
{
    private $dispatcher;
    private $urlGenerator;
    private $manager;
    private $encoders;

    public function __construct(
        EventDispatcherInterface $dispatcher,
        UrlGeneratorInterface $urlGenerator,
        ObjectManager $manager,
        EncoderFactoryInterface $encoders
    ) {
        $this->dispatcher = $dispatcher;
        $this->urlGenerator = $urlGenerator;
        $this->manager = $manager;
        $this->encoders = $encoders;
    }

    public function handle(Registration $registration)
    {
        $user = new User(
            $registration->getEmail(),
            $registration->getFirstName(),
            $registration->getLastName(),
            $registration->getGender(),
            $registration->getBirthdate(),
            $this->encodePassword($registration->getPassword()),
            User::ROLE_USER,
            User::DISABLED,
            new PostAddressEmbeddable(
                $registration->getCountry(),
                $registration->getCity(),
                $registration->getAddress(),
                $registration->getZipCode()
            )
        );
        $this->manager->persist($user);
        $this->manager->flush();

        $token = UserActivationToken::generate($user);
        $this->manager->persist($token);
        $this->manager->flush();

        $this->dispatcher->dispatch(
            Events::USER_REGISTRATION_COMPLETED,
            new GenericEvent(['user' => $user, 'activation_token' => $token])
        );
    }

    public function update(User $user, Registration $registration)
    {
        $user->update($registration);
        $this->manager->flush();

        $this->dispatcher->dispatch(Events::USER_PROFILE_UPDATED, new GenericEvent(['user' => $user]));
    }

    public function encodePassword(string $password): string
    {
        $encoder = $this->encoders->getEncoder(User::class);

        return $encoder->encodePassword($password, null);
    }
}
