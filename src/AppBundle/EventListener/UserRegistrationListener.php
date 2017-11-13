<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Entity\UserExpirableTokenInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserRegistrationListener
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @param string
     */
    private $sender_email;

    public function __construct(\Swift_Mailer $mailer, UrlGeneratorInterface $urlGenerator, string $sender_email)
    {
        $this->mailer = $mailer;
        $this->urlGenerator = $urlGenerator;
        $this->sender_email = $sender_email;
    }

    public function onUserRegistrationCompleted(GenericEvent $event)
    {
        $user = $event->getSubject()['user'];
        $activation_token = $event->getSubject()['activation_token'];

        $this->sendActivationEmail($user, $this->generateUserActivationUrl($user, $activation_token));
    }

    private function sendActivationEmail(User $user, string $activationUrl): void
    {
        $body = <<<BODY
Hello {$user->getFullName()}!

Use this link to activate your account:

{$activationUrl}
BODY;

        $message = $this->mailer->createMessage()
            ->setSubject('Activation')
            ->setFrom($this->sender_email)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/plain');

        $this->mailer->send($message);
    }

    private function generateUserActivationUrl(User $user, UserExpirableTokenInterface $token): string
    {
        $params = [
            'user_id' => (string)$user->getId(),
            'activation_token' => (string)$token->getValue(),
        ];

        return $this->urlGenerator->generate('activate', $params, UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
