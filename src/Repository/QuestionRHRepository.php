<?php

namespace App\Repository;

use App\Entity\QuestionRH;
use App\Entity\User;
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
            ->leftJoin('d.demandeur', 'u')
            ->where(':searchTerm = \'\' OR 
                d.faitLe LIKE :searchTerm OR
                s.label LIKE :searchTerm OR
                u.username LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->orderBy('d.faitLe', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionRH::class);
    }

    public function findOneByIDandUser(int $id, User $user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.demandeur', 'u')
            ->andWhere('a.id = :id')
            ->andWhere('u = :user')
            ->setParameter('id', $id)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
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
