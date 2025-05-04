<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\ThirdParty;

use App\Application\Command\ThirdParty\ThirdPartyCreate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\ThirdParty\Form\ThirdPartyCreateForm;
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
    path: '/api/saga/v1/third-party',
    name: 'api_saga_v1_third_party_create',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_POST],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/ThirdParty/')]
final class ThirdPartyCreateController extends AbstractController
{
    #[BehatFeature(status: Status::FAILURE, file: 'Create.feature', anchors: [
        'dsd',
    ])]
    #[Rest\View(statusCode: Response::HTTP_NO_CONTENT)]
    #[ApiDoc\Operation(['tags' => ['Saga']])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            ref: new ApiDoc\Model(type: ThirdPartyCreateForm::class),
        ),
    )]
    #[OA\Post(summary: 'Create Third Party call', responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Create Third Party call',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        CommandBus $commandBus,
        ThirdPartyCreateForm $form
    ): void {
        $commandBus->dispatch(new ThirdPartyCreate($form->event, $form->email, $form->language));
    }
}
