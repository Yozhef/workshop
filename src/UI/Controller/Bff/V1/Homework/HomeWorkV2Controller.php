<?php
declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\Homework;

use App\Domain\Repository\HomeworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeWorkV2Controller extends AbstractController
{
    public function __construct(private readonly HomeworkRepository $homeworkRepository)
    {
    }
    #[Route(
        path: '/api/bff/v1/home-work/{id}',
        name: 'find_home_work_by_id',
        requirements: ['id' => '[0-9a-fA-F\-]{36}'],
        defaults: ['_format' => 'json', 'anonymous' => true],
        methods: [Request::METHOD_GET],
    )]
    public function findOne(string $id): JsonResponse
    {
        $homework = $this->homeworkRepository->find($id);

        return $this->json($homework, Response::HTTP_OK);
    }

    #[Route(
        path: '/api/bff/v1/home-work/list}',
        name: 'list_all_home_works',
        defaults: ['_format' => 'json', 'anonymous' => true],
        methods: [Request::METHOD_GET],
    )]
    public function listAll(): JsonResponse
    {
        $allHomeworks = $this->homeworkRepository->findAll();

        return $this->json($allHomeworks, Response::HTTP_OK);
    }
}
