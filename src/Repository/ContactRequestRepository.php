<?php

namespace App\Repository;

use App\Entity\ContactRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactRequest[]    findAll()
 * @method ContactRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactRequest::class);
    }


    public function findByEmail()
    {
        return $this->createQueryBuilder('r')
            ->select('r.email')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Request
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
