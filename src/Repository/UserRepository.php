<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllUsersOrderedByMail(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email IS NOT NULL')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function whereEmailIsFooFoo($email): ?User
    {
        return $this->createQueryBuilder('u')
            ->setParameter('email', "%$email%")
            ->andWhere('u.email LIKE :email')
            ->getQuery()
            ->getOneOrNullResult();
    }

     /**
     * @return User[] Returns an array of User objects
     */
    public function WhereUserGetRolesUser($userRoles): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('roles', "%$userRoles%")
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

       /**
     * @return User[] Returns an array of User objects
     */
    public function inactifUser(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.enabled = :false')
            ->setParameter('false', false)
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

}

