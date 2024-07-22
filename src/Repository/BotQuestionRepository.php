<?php

namespace App\Repository;

use App\Entity\BotQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BotQuestion>
 *
 * @method BotQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method BotQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method BotQuestion[]    findAll()
 * @method BotQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BotQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BotQuestion::class);
    }

    public function getDataFromSearch($searchTerm)
    {
        return $this->createQueryBuilder('q')
            ->select('q')
            ->where(':searchTerm = \'\' OR 
                q.question LIKE :searchTerm OR
                q.reponse LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return BotQuestion[] Returns an array of BotQuestion objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BotQuestion
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
