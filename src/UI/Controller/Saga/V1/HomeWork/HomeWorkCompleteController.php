<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeWork;

use App\Application\Command\HomeWork\HomeWorkComplete;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\HomeWork\Form\HomeWorkCompleteByIdForm;
use BehatNelmioDescriber\Attributes\BehatFeature;
use BehatNelmioDescriber\Attributes\BehatFeaturesPath;
use BehatNelmioDescriber\Enum\Status;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/saga/v1/home-work/{id}/complete',
    name: 'api_saga_v1_home_work_complete',
    requirements: ['id' => '[0-9a-fA-F\-]{36}'],
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_POST],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/HomeWork/')]
final class HomeWorkCompleteController extends AbstractController
{
    #[BehatFeature(status: Status::SUCCESS, file: 'ById.feature', anchors: [
        'success',
    ])]
    #[BehatFeature(status: Status::FAILURE, file: 'Complete.feature', anchors: [
        'failInvalidId',
        'failDeadlinePassed'
    ])]
    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[ApiDoc\Operation(['tags' => ['Saga']])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Post(summary: 'Complete home work', responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Complete home work',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(CommandBus $queryBus, HomeWorkCompleteByIdForm $form): void
    {
        $queryBus->dispatch(new HomeWorkComplete($form->id));
    }
}
