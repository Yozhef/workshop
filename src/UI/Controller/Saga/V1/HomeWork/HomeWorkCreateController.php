<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeWork;

use App\Application\Command\HomeWork\AsyncMessage\AsyncHomeWorkMessageCreate;
use App\Application\Command\HomeWork\HomeWorkCreate;
use App\Infrastructure\MessageBus\CommandBus;
use App\UI\Controller\Saga\V1\HomeWork\Form\HomeWorkCreateForm;
use BehatNelmioDescriber\Attributes\BehatFeature;
use BehatNelmioDescriber\Attributes\BehatFeaturesPath;
use BehatNelmioDescriber\Enum\Status;
use DateInterval;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use OpenApi\Attributes as OA;

#[Route(
    path: 'api/saga/v1/homework',
    name: 'api_saga_v1_homework_create',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_POST],
)]
#[BehatFeaturesPath(path: 'Api/Saga/V1/HomeWork/')]
class HomeWorkCreateController extends AbstractController
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
            ref: new ApiDoc\Model(type: HomeWorkCreateForm::class),
        ),
    )]
    #[OA\Post(summary: 'Create home work', responses: [
        new OA\Response(
            response: Response::HTTP_NO_CONTENT,
            description: 'Create home work',
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        CommandBus $commandBus,
        HomeWorkCreateForm $form
    ): void {
        try {
            $dueDate = new DateTimeImmutable($form->dueDate);
        } catch (\Exception $e) {
            $dueDate = new DateTimeImmutable('now')->add(new DateInterval('P1D'));
        }

        $commandBus->dispatch(new HomeWorkCreate($form->id, $form->title, $dueDate));

        $commandBus->dispatch(new AsyncHomeWorkMessageCreate(
            $form->id,
            $form->title,
            $form->dueDate,
        ));
    }
}