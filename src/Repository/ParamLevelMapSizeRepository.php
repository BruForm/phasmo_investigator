<?php

namespace App\Repository;

use App\Entity\ParamLevelMapSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParamLevelMapSize>
 *
 * @method ParamLevelMapSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParamLevelMapSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParamLevelMapSize[]    findAll()
 * @method ParamLevelMapSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamLevelMapSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParamLevelMapSize::class);
    }

    public function save(ParamLevelMapSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParamLevelMapSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ParamLevelMapSize[] Returns an array of ParamLevelMapSize objects
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

//    public function findOneBySomeField($value): ?ParamLevelMapSize
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
