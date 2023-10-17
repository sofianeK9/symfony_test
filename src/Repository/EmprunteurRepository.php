<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }

    /**
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findAllEmprunteur(): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom IS NOT NULL')
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findWordFoo($word): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :word')
            ->orWhere('e.prenom LIKE :word')
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->setParameter('word', "%$word%")
            ->getQuery()
            ->getResult();
    }

    public function findTel($tel): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tel LIKE :tel')
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->setParameter('tel', "%$tel%")
            ->getQuery()
            ->getResult();
    }
}
