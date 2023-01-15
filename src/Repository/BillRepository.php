<?php

namespace App\Repository;

use App\Entity\Bill;
use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\FormInterface;

/**
 * @extends ServiceEntityRepository<Bill>
 *
 * @method Bill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bill[]    findAll()
 * @method Bill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bill::class);
    }

    public function save(Bill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bill $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Bill[] Returns an array of Bill objects
     */
    public function groupBillsByTypeForProperty(Property $property): array
    {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.priceTotal) as sum, b.type')
            ->groupBy('b.type')
            ->andWhere('b.property = :property')
            ->setParameter('property', $property->getId()->toBinary())
            ->getQuery()
            ->getArrayResult()
        ;
    }

    public function archiveSearch(Property $property, FormInterface $form): Query
    {
        $query = $this->createQueryBuilder('b');
        $query
            ->andWhere('b.archived = true')
            ->andWhere('b.property = :property')
            ->setParameter(':property', $property->getId()->toBinary());

        if (null !== $name = $form->get('name')->getData()) {
            $query
                ->andWhere("b.name LIKE :val")
                ->setParameter('val', '%' . $name . '%');
        }
        if (null !== $priceMin = $form->get('priceMin')->getData()) {
            $query
                ->andWhere("b.priceTotal >= :priceMin")
                ->setParameter('priceMin', $priceMin*100);
        }
        if (null !== $priceMax = $form->get('priceMax')->getData()) {
            $query
                ->andWhere("b.priceTotal <= :priceMax")
                ->setParameter('priceMax', $priceMax*100);
        }
        if (null !== $dateFrom = $form->get('dateFrom')->getData()) {
            $query
                ->andWhere("b.createdAt >= :dateFrom")
                ->setParameter('dateFrom', $dateFrom);
        }
        if (null !== $dateTo = $form->get('dateTo')->getData()) {
            $query
                ->andWhere("b.createdAt <= :dateTo")
                ->setParameter('dateTo', $dateTo);
        }
        return $query
            ->getQuery()
            ;
    }

//    public function findOneBySomeField($value): ?Bill
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
