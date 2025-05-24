<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeWork;

use App\Application\Command\DefaultEntity\DefaultEntityCreate;
use App\Application\Command\HomeWork\HomeWorkComplete;
use App\Application\Command\HomeWork\HomeWorkCreate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Bff\V1\HomeWork\Form\HomeWorkByIdForm;
use App\UI\Controller\Saga\V1\DefaultEntity\Form\DefaultEntityCreateForm;
use App\UI\Controller\Saga\V1\HomeWork\Form\HomeWorkCreateForm;
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
    path: '/api/saga/v1/homeworks/complete',
    name: 'api_saga_v1_home_work_complete',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_POST],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/HomeWork/')]
final class HomeWorkCompleteController extends AbstractController
{
    #[BehatFeature(status: Status::FAILURE, file: 'Create.feature', anchors: [
        'failBlankParams',
        'failEntityAlreadyExist',
        'failInvalidId',
    ])]
    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[ApiDoc\Operation(['tags' => ['Saga']])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new ApiDoc\Model(type: HomeWorkByIdForm::class),
        ),
    )]
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
    public function __invoke(
        CommandBus $commandBus,
        HomeWorkByIdForm $form,
    ): void {
        $commandBus->dispatch(new HomeWorkComplete($form->id));
    }
}
