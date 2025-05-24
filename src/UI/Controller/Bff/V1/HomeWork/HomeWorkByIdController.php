<?php

declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\HomeWork;

use App\Application\Query\HomeWork\HomeWorkById;
use App\Domain\Entity\HomeWork;
use App\Infrastructure\MessageBus\QueryBus;
use App\UI\Controller\Bff\V1\HomeWork\Form\HomeWorkByIdForm;
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
    path: '/api/bff/v1/home-work/{id}',
    name: 'api_bff_v1_home_work_by_id',
    requirements: ['id' => '[0-9a-fA-F\-]{36}'],
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_GET],
)]
#[BehatFeaturesPath(path: 'Api/Bff/V1/HomeWork/')]
final class HomeWorkByIdController extends AbstractController
{
    /**
     * @param QueryBus<HomeWork> $queryBus
     */
    #[BehatFeature(status: Status::SUCCESS, file: 'HomeWork.ById.feature', anchors: [
        'success',
    ])]
    #[BehatFeature(status: Status::FAILURE, file: 'HomeWork.ById.feature', anchors: [
        'failInvalidId',
    ])]
    #[Rest\View(statusCode: Response::HTTP_OK, serializerGroups: ['home_work_default', 'response_dto_default'])]
    #[ApiDoc\Operation(['tags' => ['BFF']])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Get(summary: 'Get home work.', responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: 'Entity info',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        ref: new ApiDoc\Model(
                            type: HomeWork::class,
                            groups: ['home_work_default', 'response_dto_default'],
                        ),
                        description: 'Entity data',
                    ),
                ],
            ),
        ),
        new OA\Response(
            response: Response::HTTP_BAD_REQUEST,
            description: 'Validation Failed',
            content: new OA\JsonContent(ref: '#/components/schemas/error.400'),
        ),
    ])]
    public function __invoke(
        QueryBus $queryBus,
        HomeWorkByIdForm $form,
    ): HomeWork {
        return $queryBus->query(new HomeWorkById($form->id));
    }
}
