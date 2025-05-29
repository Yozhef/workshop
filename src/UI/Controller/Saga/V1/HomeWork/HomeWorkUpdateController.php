<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeWork;

use App\Application\Command\HomeWork\HomeWorkUpdate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\HomeWork\Form\HomeWorkUpdateForm;
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
    path: '/api/saga/v1/home-work',
    name: 'api_saga_v1_home_work_update',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_PATCH],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/HomeWork/')]
final class HomeWorkUpdateController extends AbstractController
{
    #[BehatFeature(status: Status::FAILURE, file: 'Update.feature', anchors: [
        'failBlankParams',
        'failInvalidId',
        'failNotFound',
    ])]
    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[ApiDoc\Operation(['tags' => ['Saga']])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new ApiDoc\Model(type: HomeWorkUpdateForm::class),
        ),
    )]
    #[OA\Patch(responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Entity updated',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        CommandBus $queryBus,
        HomeWorkUpdateForm $form,
    ): void {
        $queryBus->dispatch(new HomeWorkUpdate($form->id, $form->title, $form->dueDate));
    }
}
