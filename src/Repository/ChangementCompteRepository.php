<?php

namespace App\Repository;

use App\Entity\ChangementCompte;
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
            ->where(':searchTerm = \'\' OR 
                d.nom LIKE :searchTerm OR
                d.faitLe LIKE :searchTerm OR
                s.label LIKE :searchTerm OR
                d.fonction LIKE :searchTerm OR
                d.prenom LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChangementCompte::class);
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
