<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\OrderByItem;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    /**
     * @return Emprunt[] Returns an array of Emprunt objects
     */
    public function findTenLastEmprunt($value): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateEmprunt', 'DESC')
            ->setMaxResults($value)
            ->getQuery()
            ->getResult();
    }

    public function findEmprunt2($value): array
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.emprunteur = :value')
        ->setParameter('value', $value)
        ->orderBy('e.dateEmprunt', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function findEmprunt3($value): array
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.emprunteur = :value')
        ->setParameter('value', $value)
        ->orderBy('e.dateEmprunt', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findEmpruntNull(): array
    {
        return $this->createQueryBuilder('e')
        ->where('e.dateRetour IS NULL')
        ->orderBy('e.dateEmprunt', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function EmpruntLivre3($value): array
    {
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.livre = :value')
        ->setParameter('value', $value)
        ->getQuery()
        ->getResult();
    }


}
