<?php

namespace App\Repository;

use App\Entity\RdvAvec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RdvAvec>
 *
 * @method RdvAvec|null find($id, $lockMode = null, $lockVersion = null)
 * @method RdvAvec|null findOneBy(array $criteria, array $orderBy = null)
 * @method RdvAvec[]    findAll()
 * @method RdvAvec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RdvAvecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RdvAvec::class);
    }

//    /**
//     * @return RdvAvec[] Returns an array of RdvAvec objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RdvAvec
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
