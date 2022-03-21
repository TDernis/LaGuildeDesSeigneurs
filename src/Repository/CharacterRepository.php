<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    public function findOneByIdentifier($identifier)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'c')
            ->leftJoin('p.player', 'c')
            ->where('p.identifier = :identifier')
            ->setParameter('identifier', $identifier)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllByIntelligence($intelligence)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.intelligence >= :intelligence')
            ->setParameter('intelligence', $intelligence)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all Character and players by life in Character
     */
    public function findAllByLife($life)
    {
        return $this->createQueryBuilder('c')
            ->select('c','p')
            ->leftJoin('c.player', 'p')
            ->where('c.life >= :life')
            ->setParameter('life', $life)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all Character and players by caste in Character
     */
    public function findAllByCaste($caste)
    {
        return $this->createQueryBuilder('c')
            ->select('c','p')
            ->leftJoin('c.player', 'p')
            ->where('c.caste = :caste')
            ->setParameter('caste', $caste)
            ->getQuery()
            ->getResult();
    }

    /**
     * Get all Character and players by Knowledge in Character
     */
    public function findAllByKnowledge($knowledge)
    {
        return $this->createQueryBuilder('c')
            ->select('c','p')
            ->leftJoin('c.player', 'p')
            ->where('c.knowledge = :knowledge')
            ->setParameter('knowledge', $knowledge)
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Character[] Returns an array of Character objects
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
    public function findOneBySomeField($value): ?Character
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
