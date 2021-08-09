<?php

namespace App\Services;

use App\Entity\Classroom;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClassroomService
{
    /**
     * @var EntityManager
     */
    public $entityManager;

    /**
     * @var ValidatorInterface
     */
    public $validator;

    /**
     * @InjectParams({
     *    "entityManager" = @Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @throws ORMException
     */
    public function create(array $data)
    {
        $classroom = new Classroom();

        $classroom->setName($data['name']);
        $classroom->setCreatedAt(date_create());
        $classroom->setIsActive($data['is_active']);

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();
    }

    /**
     * @param array $data
     * @param Classroom $classroom
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(array $data, Classroom $classroom)
    {
        $classroom = $classroom->setParameters($data);

        $this->entityManager->persist($classroom);
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(Classroom $classroom)
    {
        $this->entityManager->remove($classroom);
        $this->entityManager->flush();
    }
}