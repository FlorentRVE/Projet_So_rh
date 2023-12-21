<?php

namespace App\Repository;

use App\Entity\AttestationEmployeur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttestationEmployeur>
 *
 * @method AttestationEmployeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationEmployeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationEmployeur[]    findAll()
 * @method AttestationEmployeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationEmployeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationEmployeur::class);
    }

//    /**
//     * @return AttestationEmployeur[] Returns an array of AttestationEmployeur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AttestationEmployeur
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
