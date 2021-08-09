<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Exception\EntityException;
use App\Exception\ValidationException;
use App\Repository\ClassroomRepository;
use App\Services\ClassroomService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;

/**
 * @Route("/classroom")
 */
class ClassroomController extends AbstractController
{
    /**
     * @var ClassroomService
     */
    public $classroomService;

    /**
     * @var ClassroomRepository
     */
    public $classroomRepository;

    public function __construct(ClassroomService $classroomService, ClassroomRepository $classroomRepository)
    {
        $this->classroomService = $classroomService;
        $this->classroomRepository = $classroomRepository;
    }

    /**
     * @Route("/", name="classroom_list", methods={"GET"})
     */
    public function list(Request $request, PaginatorInterface $paginator): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $perPage = $request->query->getInt('perPage', 10);

        $classrooms = $this->classroomRepository->paginate($page, $perPage);

        return $this->json($classrooms);
    }

    /**
     * @Route("/new", name="classroom_new", methods={"POST"})
     * @throws ValidationException
     * @throws EntityException
     */
    public function new(Request $request): JsonResponse
    {
        $data = $request->toArray();

        $constraint = new Collection([
            'name' => [
                new NotBlank(),
                new Length(['max' => 64]),
                new Type(['type' => 'string']),
            ],
            'is_active' => [
                new Type(['type' => 'boolean'])
            ],
        ]);

        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $constraint);

        if (0 !== count($violations)) {
            throw new ValidationException($violations);
        }

        try {
            $this->classroomService->create($data);
        }catch (\Exception $exception) {
            throw new EntityException('Creating failed');
        }

        return $this->json('success');
    }

    /**
     * @Route("/show/{id}", name="classroom_show", methods={"GET"})
     */
    public function show(Classroom $classroom): Response
    {
        return $this->json($classroom);
    }

    /**
     * @Route("/update/{id}", name="classroom_edit", methods={"POST"})
     * @throws ValidationException
     * @throws EntityException
     */
    public function update(Request $request, Classroom $classroom): JsonResponse
    {
        $data = $request->toArray();

        $constraint = new Collection([
            'name' => new Optional([
                new Length(['max' => 64]),
                new Type(['type' => 'string']),
            ]),
            'is_active' => new Optional([
                new NotBlank(),
                new Type(['type' => 'boolean'])
            ]),
        ]);

        $validator = Validation::createValidator();
        $violations = $validator->validate($data, $constraint);

        if (0 !== count($violations)) {
            throw new ValidationException($violations);
        }

        try {
            $this->classroomService->update($data, $classroom);
        }catch (ORMException|OptimisticLockException $exception) {
            throw new EntityException('Updating failed');
        }

        return $this->json('success');
    }

    /**
     * @Route("/delete/{id}", name="classroom_delete", methods={"DELETE"})
     * @throws EntityException
     */
    public function delete(Classroom $classroom): Response
    {
        try {
            $this->classroomService->delete($classroom);
        } catch (OptimisticLockException|ORMException $exception) {
            throw new EntityException('Deleting failed');
        }

        return $this->json('Removed');
    }

    /**
     * @Route("/change-status/{id}", name="classroom_change_status", methods={"GET"})
     * @throws EntityException
     */
    public function changeStatus(Classroom $classroom): JsonResponse
    {
        $data['is_active'] = !($classroom->getIsActive() == true);

        try {
            $this->classroomService->update($data, $classroom);
        }catch (ORMException|OptimisticLockException $exception) {
            throw new EntityException('Status changing failed');
        }

        return $this->json("Status changed");
    }
}
