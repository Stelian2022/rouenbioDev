<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * Finds carts that have not been modified since the given date.
     *
     * @param \DateTime $limitDa
     * @param int $limit
     *
     * @return int|mixed|string
     */
    public function findCartsNotModifiedSince(\DateTimeImmutable $limitDate, int $limit = 10): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.status = :status')
            ->andWhere('o.updatedAt < :date')
            ->setParameter('status', Order::STATUS_CART)
            ->setParameter('date', $limitDate)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findById(\DateTimeImmutable $limitDate, int $limit = 10): array
    {
        $results = $this->createQueryBuilder('o')
            ->select('o.id') // Select only the ID
            ->andWhere('o.status = :status')
            ->andWhere('o.updatedAt < :date')
            ->setParameter('status', Order::STATUS_CART)
            ->setParameter('date', $limitDate)
            ->setMaxResults($limit)
            ->getQuery()
            ->getScalarResult();

        // Extract the IDs from the results array
        $ids = array_column($results, 'id');

        return $ids;
    }
    public function trierDate()
    {
        $orders = $this->findAll();
        $dates = [];
        foreach ($orders as $order) {
            $noms[] = $order->getCreatedAt(); // Ajoute le nom de chaque utilisateur à la liste des noms
        }
        sort($dates); // Trie les noms dans l'ordre alphabétique
        return $dates;
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Order[] Returns an array of Order objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Order
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
