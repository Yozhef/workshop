<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\AsyncMessage;

use App\Application\Command\AsyncMessage\AsyncMessageCreate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\AsyncMessage\Form\AsyncMessageCreateForm;
use App\UI\Controller\Saga\V1\DefaultEntity\Form\DefaultEntityCreateForm;
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
    path: '/api/saga/v1/async-message',
    name: 'api_saga_v1_async_message_create',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_POST],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/AsyncMessage/')]
final class AsyncMessageController extends AbstractController
{
    #[BehatFeature(status: Status::FAILURE, file: 'Create.feature', anchors: [
        'failInvalidId',
    ])]
    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[ApiDoc\Operation(['tags' => ['Saga']])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new ApiDoc\Model(type: AsyncMessageCreateForm::class),
        ),
    )]
    #[OA\Post(summary: 'Create async message', responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Create async message',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        CommandBus $queryBus,
        DefaultEntityCreateForm $form
    ): void {
        $queryBus->dispatch(new AsyncMessageCreate($form->id, $form->name));
    }
}
