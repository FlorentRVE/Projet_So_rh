<?php

namespace App\Repository;

use App\Entity\AttestationEmployeur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AttestationEmployeur>
 *
 * @method AttestationEmployeur|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttestationEmployeur|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttestationEmployeur[]    findAll()
 * @method AttestationEmployeur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttestationEmployeurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttestationEmployeur::class);
    }

    public function getDataFromSearch($searchTerm)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->leftJoin('d.service', 's')
            ->leftJoin('d.demandeur', 'u')
            ->where(':searchTerm = \'\' OR 
                d.email LIKE :searchTerm OR
                u.username LIKE :searchTerm OR
                d.telephone LIKE :searchTerm OR
                s.label LIKE :searchTerm OR
                d.fonction LIKE :searchTerm OR
                d.motif LIKE :searchTerm OR
                d.recuperation LIKE :searchTerm OR
                d.faitLe LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->orderBy('d.faitLe', 'DESC')            
            ->getQuery()
            ->getResult();
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
    //     * @return AttestationEmployeur[] Returns an array of AttestationEmployeur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AttestationEmployeur
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
