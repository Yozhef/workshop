<?php
declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\Homework;

use App\Application\Command\Homework\HomeworkCreate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\Homework\Form\HomeworkCreateForm;
use BehatNelmioDescriber\Attributes\BehatFeaturesPath;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/api/saga/v1/homework', name: 'api_saga_v1_homework_create', defaults: [
    '_format' => 'json',
    'anonymous' => true,
], methods: [Request::METHOD_POST],)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/Homework/')]
class HomeworkCreateController extends AbstractController
{
    public function __invoke(
        CommandBus $commandBus,
        HomeworkCreateForm $form
    ): JsonResponse {
        $commandBus->dispatch(new HomeworkCreate($form->id, $form->name, $form->description));

        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
