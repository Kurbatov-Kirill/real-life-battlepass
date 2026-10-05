<?php

namespace App\Repository;

use App\Entity\Battlepass;
use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Battlepass>
 */
class BattlepassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Battlepass::class);
    }

    public function findAllForUser(Profile $user): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.player1 = :user OR b.player2 = :user')
            ->setParameter('user', $user)
            ->orderBy('b.startAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
