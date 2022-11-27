<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function save(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sumForStats(): array
    {
//        SELECT SUM(p.nbInvestig), SUM (p.nbSuccess)
//        FROM player
        return $this->createQueryBuilder('p')
            ->select('SUM(p.nbInvestig) as nbInvestig', 'SUM(p.nbSuccess) as nbSuccess')
            ->getQuery()
            ->getResult();
    }

    public function sumForStatsByEmail(string $email): array
    {
//        SELECT SUM(p.nbInvestig), SUM (p.nbSuccess)
//        FROM player p
//        WHERE p.nickname =
//          (SELECT u.nickname FROM user u
//           WHERE u.email = $email)
//        OU :
//        SELECT SUM(p.nb_investig) , SUM(p.nb_success)
//        FROM player p
//        INNER JOIN user u ON u.nickname = p.nickname
//          AND u.email = 'bruno@mail.fr';
        return $this->createQueryBuilder('p')
            ->select('SUM(p.nbInvestig) as nbInvestig', 'SUM(p.nbSuccess) as nbSuccess')
            ->innerJoin(User::class, 'u', 'WITH', 'u.nickname = p.nickname AND u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult();

//        ->where('p.nickname = (SELECT nickname FROM user WHERE email = :email)')
    }

//    /**
//     * @return Player[] Returns an array of Player objects
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

//    public function findOneBySomeField($value): ?Player
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
