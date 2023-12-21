<?php

namespace App\Repository;

use App\Entity\DemandeBulletinSalaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeBulletinSalaire>
 *
 * @method DemandeBulletinSalaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeBulletinSalaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeBulletinSalaire[]    findAll()
 * @method DemandeBulletinSalaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeBulletinSalaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeBulletinSalaire::class);
    }

//    /**
//     * @return DemandeBulletinSalaire[] Returns an array of DemandeBulletinSalaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DemandeBulletinSalaire
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
