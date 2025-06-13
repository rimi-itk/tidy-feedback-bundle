<?php

namespace ItkDev\TidyFeedbackBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use ItkDev\TidyFeedbackBundle\Entity\FeedbackItem;

/**
 * @extends ServiceEntityRepository<FeedbackItem>
 */
class FeedbackItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeedbackItem::class);
    }

    public function persist(FeedbackItem $item, bool $flush = false): FeedbackItem
    {
        $this->_em->persist($item);
        if ($flush) {
            $this->_em->flush();
        }

        return $item;
    }

    //    /**
    //     * @return FeedbackItem[] Returns an array of FeedbackItem objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FeedbackItem
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
