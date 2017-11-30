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
        $query = $this
            ->createQueryBuilder('u')
            ->where('u.email = :username')
            ->andWhere('u.status = :status')
            ->setParameter('username', $username)
            ->setParameter('status', User::ENABLED)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findByEmail(string $email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findActiveUsersByOffice(Office $office): array
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where('u.status = :status AND u.office = :office')
            ->setParameter('status', User::ENABLED)
            ->setParameter('office', $office)
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countActiveUsersByOffice(Office $office): int
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->select('COUNT(u.id)')
            ->where('u.status = :status AND u.office = :office')
            ->setParameter('status', User::ENABLED)
            ->setParameter('office', $office)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createActiveUsersWithoutOfficeQB()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where('u.role = :role AND u.status = :status AND u.office IS NULL')
            ->setParameter('role', User::ROLE_USER)
            ->setParameter('status', User::ENABLED)
            ->addOrderBy('u.lastName', 'ASC')
            ->addOrderBy('u.firstName', 'ASC');
    }
}
