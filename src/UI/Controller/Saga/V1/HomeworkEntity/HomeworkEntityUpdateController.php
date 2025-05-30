<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeworkEntity;

use App\Application\Command\HomeworkEntity\HomeworkEntityUpdate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\HomeworkEntity\Form\HomeworkEntityUpdateForm;
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
    path: '/api/saga/v1/homework-entity',
    name: 'api_saga_v1_homework_entity_update',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_PATCH],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/HomeworkEntity/')]
final class HomeworkEntityUpdateController extends AbstractController
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
            ref: new ApiDoc\Model(type: HomeworkEntityUpdateForm::class),
        ),
    )]
    #[OA\Patch(responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Homework entity updated',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        CommandBus $queryBus,
        HomeworkEntityUpdateForm $form,
    ): void {
        $queryBus->dispatch(new HomeworkEntityUpdate($form->id, $form->title, $form->description));
    }
}
