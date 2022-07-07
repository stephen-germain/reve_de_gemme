<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    public function add(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Products $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Products[] Returns an array of Products objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Products
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    // public function findOneByCategorie($produit)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.categories = :val')
    //         ->setParameter('val', $produit)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    public function findFourFirst()
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.id > :val')
            ->setParameter('val', '0')
            ->orderBy('f.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findFourAfter()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id > :val')
            ->setParameter('val', '0')
            ->orderBy('a.id', 'DESC')
            ->setFirstResult(4)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findFourLast()
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.id > :val')
            ->setParameter('val', '0')
            ->orderBy('l.id', 'DESC')
            ->setFirstResult(8)
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
}
