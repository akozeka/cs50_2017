<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Office;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface, UserProviderInterface
{
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        $username = $user->getUsername();

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                "User of type \"{$class}\" and identified by \"{$username}\" is not supported by this provider!"
            );
        }

        if (!$user = $this->loadUserByUsername($username)) {
            throw new UsernameNotFoundException("Unable to find User identified by \"{$username}\"!");
        }

        return $user;
    }

    public function supportsClass($class)
    {
        return $class === User::class;
    }

    public function loadUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where('u.email = :username AND u.status = :status')
            ->setParameter('username', $username)
            ->setParameter('status', User::ENABLED)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findActiveUsersByOffice(Office $office): array
    {
        $qb = $this->createActiveUsersQB();

        return $qb
            ->andWhere('u.office = :office')
            ->setParameter('office', $office)
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countActiveUsersByOffice(Office $office): int
    {
        $qb = $this->createActiveUsersQB();

        return $qb
            ->select('COUNT(u.id)')
            ->andWhere('u.office = :office')
            ->setParameter('office', $office)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createActiveUsersQB()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where('u.role = :role AND u.status = :status')
            ->setParameter('role', User::ROLE_USER)
            ->setParameter('status', User::ENABLED)
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC');
    }
}
