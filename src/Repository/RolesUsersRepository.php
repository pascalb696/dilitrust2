<?php

namespace App\Repository;

use App\Entity\RolesUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RolesUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method RolesUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method RolesUsers[]    findAll()
 * @method RolesUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesUsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RolesUsers::class);
    }

    // /**
    //  * @return RolesUsers[] Returns an array of RolesUsers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RolesUsers
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
