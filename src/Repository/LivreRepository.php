<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */
    public function findAllBooks(): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre IS NOT NULL')
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findTitle($title): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.titre LIKE :titre')
            ->setParameter('titre', "%$title%")
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Livre[] Returns an array of Livre objects
     */
    public function findGenreName($genre): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.genres', 'genres')
            ->andWhere('genres.nom LIKE :genres')
            ->setParameter('genres', "%$genre%")
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
