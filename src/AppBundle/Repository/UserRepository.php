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

//    public function countActiveUsers(): int
//    {
//        $query = $this
//            ->createQueryBuilder('u')
//            ->select('COUNT(u.id)')
//            ->where('u.status = :status')
//            ->setParameter('status', User::ENABLED)
//            ->getQuery();
//
//        return (int)$query->getSingleScalarResult();
//    }

//    public function findList(array $ids): UserCollection
//    {
//        if (empty($ids)) {
//            return new UserCollection();
//        }
//
//        $qb = $this->createQueryBuilder('u');
//        $query = $qb
//            ->where($qb->expr()->in('u.id', $ids))
//            ->getQuery();
//
//        return new UserCollection($query->getResult());
//    }
}
