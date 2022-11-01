<?php

namespace App\Repository;

use App\Entity\ParamLevelMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParamLevelMap>
 *
 * @method ParamLevelMap|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParamLevelMap|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParamLevelMap[]    findAll()
 * @method ParamLevelMap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamLevelMapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParamLevelMap::class);
    }

    public function save(ParamLevelMap $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParamLevelMap $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ParamLevelMap[] Returns an array of ParamLevelMap objects
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

//    public function findOneBySomeField($value): ?ParamLevelMap
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
