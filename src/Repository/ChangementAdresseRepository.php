<?php

namespace App\Repository;

use App\Entity\ChangementAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ChangementAdresse>
 *
 * @method ChangementAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChangementAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChangementAdresse[]    findAll()
 * @method ChangementAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChangementAdresseRepository extends ServiceEntityRepository
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
        parent::__construct($registry, ChangementAdresse::class);
    }

    //    /**
    //     * @return ChangementAdresse[] Returns an array of ChangementAdresse objects
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

    //    public function findOneBySomeField($value): ?ChangementAdresse
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
