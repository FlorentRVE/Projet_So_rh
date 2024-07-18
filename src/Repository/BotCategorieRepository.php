<?php

namespace App\Repository;

use App\Entity\BotCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BotCategorie>
 *
 * @method BotCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method BotCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method BotCategorie[]    findAll()
 * @method BotCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BotCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BotCategorie::class);
    }

//    /**
//     * @return BotCategorie[] Returns an array of BotCategorie objects
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

//    public function findOneBySomeField($value): ?BotCategorie
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
