<?php

namespace App\Repository;

use App\Entity\QuestionRH;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuestionRH>
 *
 * @method QuestionRH|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionRH|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionRH[]    findAll()
 * @method QuestionRH[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRHRepository extends ServiceEntityRepository
{
    public function getDataFromSearch($searchTerm)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->leftJoin('d.service', 's')
            ->where(':searchTerm = \'\' OR 
                d.nom LIKE :searchTerm OR
                d.faitLe LIKE :searchTerm OR
                s.label LIKE :searchTerm OR
                d.prenom LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionRH::class);
    }

    //    /**
    //     * @return QuestionRH[] Returns an array of QuestionRH objects
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

    //    public function findOneBySomeField($value): ?QuestionRH
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
