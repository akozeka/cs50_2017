<?php

namespace AppBundle\Validator;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Utils\RegistrationInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueRegistrationValidator extends ConstraintValidator
{
    private $repository;
    private $tokenStorage;

    public function __construct(UserRepository $repository, TokenStorageInterface $tokenStorage)
    {
        $this->repository = $repository;
        $this->tokenStorage = $tokenStorage;
    }

    public function validate($registration, Constraint $constraint)
    {
        if (!$registration instanceof RegistrationInterface) {
            throw new UnexpectedTypeException($registration, RegistrationInterface::class);
        }

        if (!$constraint instanceof UniqueRegistration) {
            throw new UnexpectedTypeException($constraint, UniqueRegistration::class);
        }

        // Chosen email address is not already taken by someone else
        if (!$user = $this->repository->findByEmail($registration->getEmail())) {
            return;
        }

        // 1. User is not authenticated yet and wants to register with someone else email address.
        // 2. User is authenticated and wants to change his\her email address for someone else email address.
        $authenticatedUser = $this->getAuthenticatedUser();
        if (!$authenticatedUser || !$authenticatedUser->equals($user)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ email }}', $user->getEmail())
                ->atPath('email')
                ->addViolation();
        }
    }

    private function getAuthenticatedUser(): ?User
    {
        if (!$token = $this->tokenStorage->getToken()) {
            return null;
        }

        $user = $token->getUser();
        if (!$user instanceof User) {
            return null;
        }

        return $user;
    }
}
