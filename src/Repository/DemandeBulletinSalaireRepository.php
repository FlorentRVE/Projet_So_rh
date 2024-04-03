<?php

namespace App\Repository;

use App\Entity\DemandeBulletinSalaire;
use App\Entity\User;
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
    public function getDataFromSearch($searchTerm)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->leftJoin('d.service', 's')
            ->leftJoin('d.demandeur', 'u')
            ->where(':searchTerm = \'\' OR 
                d.faitLe LIKE :searchTerm OR
                s.label LIKE :searchTerm OR
                d.fonction LIKE :searchTerm OR
                u.username LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->orderBy('d.faitLe', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeBulletinSalaire::class);
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
