<?php

namespace App\Repository;

use App\Entity\ChangementCompte;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChangementCompte>
 *
 * @method ChangementCompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChangementCompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChangementCompte[]    findAll()
 * @method ChangementCompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChangementCompteRepository extends ServiceEntityRepository
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
            ->getQuery()
            ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChangementCompte::class);
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
    //     * @return ChangementCompte[] Returns an array of ChangementCompte objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ChangementCompte
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
