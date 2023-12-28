<?php

namespace App\Repository;

use App\Entity\DemandeAccompte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeAccompte>
 *
 * @method DemandeAccompte|null find($id, $lockMode = null, $lockVersion = null)
 * @method DemandeAccompte|null findOneBy(array $criteria, array $orderBy = null)
 * @method DemandeAccompte[]    findAll()
 * @method DemandeAccompte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DemandeAccompteRepository extends ServiceEntityRepository
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
        parent::__construct($registry, DemandeAccompte::class);
    }

    //    /**
    //     * @return DemandeAccompte[] Returns an array of DemandeAccompte objects
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

    //    public function findOneBySomeField($value): ?DemandeAccompte
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
