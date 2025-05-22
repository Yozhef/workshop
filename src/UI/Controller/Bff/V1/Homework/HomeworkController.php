<?php
declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\Homework;

use App\Domain\Repository\HomeworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeworkController extends AbstractController
{
    public function __construct(private readonly HomeworkRepository $homeworkRepository)
    {
    }

    #[Route(path: '/homeworks', name: 'homeworks_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            $homeworks = $this->homeworkRepository->findAll();
        } catch (\Exception|\Throwable $e) {
            die('General exception: '.$e->getMessage().', '.$e->getFile().', '.$e->getLine());
        }

        return $this->json(['list' => $homeworks]);
    }

    //#[Route(path: '/homeworks/{id}', name: 'homework_by_id', methods: ['GET'])]
    //public function indexById(string $id): JsonResponse
    //{
    //    try {
    //        $homework = $this->homeworkRepository->findOneBy(['id' => $id]);
    //    } catch (\Exception|\Throwable $e) {
    //        die($e->getMessage());
    //    }
    //
    //    return $this->json($homework);
    //}
}
