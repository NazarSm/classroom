<?php

namespace App\Services;

use App\Entity\Classroom;
use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\NoopWordInflector;
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

        $classroom = $this->setParameters($classroom, $data);
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
        $classroom = $this->setParameters($classroom, $data);
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

    /**
     * @param Classroom $classroom
     * @param array $params
     * @return Classroom
     */
    public function setParameters(Classroom $classroom, array $params): Classroom
    {
        $inflector = new Inflector(new NoopWordInflector(), new NoopWordInflector());

        foreach ($params as $key => $value) {

            $field = $inflector->camelize($key);

            if (property_exists($classroom, $key)) {
                $classroom->{'set' . ucfirst($field)}($value);
            }
        }

        return $classroom;
    }
}