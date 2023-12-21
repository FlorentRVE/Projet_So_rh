<?php

namespace App\Repository;

use App\Entity\QuestionPour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionPour>
 *
 * @method QuestionPour|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionPour|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionPour[]    findAll()
 * @method QuestionPour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionPourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionPour::class);
    }

//    /**
//     * @return QuestionPour[] Returns an array of QuestionPour objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?QuestionPour
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
