<?php

namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method Roles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roles[]    findAll()
 * @method Roles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Roles::class);
    }

   	public function getRolesList() {
    return $this->createQueryBuilder('roles')
        ->select('roles.id, roles.role')
//        ->innerJoin(Language::class, 'language', 'WITH', 'language.user_id = user.id')
//        ->where('language.language = :langOne AND language.language = :langTwo')
//        ->setParameter('langOne ', $langOne )
//        ->setParameter('langTwo', $langTwo)
        ->getQuery()
        ->getResult(Query::HYDRATE_ARRAY);
}
    // /**
    //  * @return Roles[] Returns an array of Roles objects
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
    public function findOneBySomeField($value): ?Roles
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
