<?php

namespace App\Repository;

use App\Entity\ContentNetflix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContentNetflix|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContentNetflix|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContentNetflix[]    findAll()
 * @method ContentNetflix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContentNetflixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContentNetflix::class);
    }

    // /**
    //  * @return ContentNetflix[] Returns an array of ContentNetflix objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContentNetflix
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
