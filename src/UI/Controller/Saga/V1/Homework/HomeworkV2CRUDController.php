<?php
declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\Homework;

use App\Domain\Entity\Homework;
use App\Domain\Repository\HomeworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

class HomeworkV2CRUDController extends AbstractController
{
    private HomeworkRepository $homeworkRepository;
    private ClientInterface $redis;
    public function __construct(HomeworkRepository $homeworkRepository, ClientInterface $redis)
    {
        $this->homeworkRepository = $homeworkRepository;
        $this->redis = $redis;

    }
    #[Route(
        path: '/homework-crud',
        name: 'homework_add',
        methods: [Request::METHOD_PUT])
    ]
    public function add(Request $request): Response
    {
        $data = $request->request->all();
        if (!empty($data['id']) && Uuid::isValid($data['id'])) {
            $id = Uuid::fromString($data['id']);
            $homeWork = new Homework($id, $data['name'], $data['description']);
            $this->homeworkRepository->add($homeWork);
            $this->redis->set($data['id'], $data['name']);
            $this->redis->save();

            return $this->json([], Response::HTTP_NO_CONTENT);
        }

        return $this->json([], Response::HTTP_BAD_REQUEST);
    }
}
