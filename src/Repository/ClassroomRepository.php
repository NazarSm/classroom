<?php

namespace App\Repository;

use App\Entity\Classroom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classroom|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classroom|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classroom[]    findAll()
 * @method Classroom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassroomRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    public $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

        parent::__construct($registry, Classroom::class);
    }

    public function paginate(int $page, int $perPage)
    {
        $firstResult = ($perPage * $page) + 1;

        $qb = $this->em->createQueryBuilder();

        $query = $qb->select('c')
            ->from('App\Entity\Classroom', 'c')
            ->setFirstResult($firstResult)
            ->setMaxResults($perPage)
            ->getQuery();

        return $query->getResult();
    }
}
