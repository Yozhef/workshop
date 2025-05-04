<?php

declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\DefaultEntity;

use App\Application\Query\DefaultEntity\DefaultEntityById;
use App\Domain\Entity\DefaultEntity;
use App\Infrastructure\MessageBus\QueryBus;
use App\UI\Controller\Bff\V1\DefaultEntity\Form\DefaultEntityByIdForm;
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
    path: '/api/bff/v1/default-entity/{id}',
    name: 'api_bff_v1_default_entity_by_id',
    requirements: ['id' => '[0-9a-fA-F\-]{36}'],
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_GET],
)]
#[BehatFeaturesPath(path: 'Api/Bff/V1/DefaultEntity/')]
final class DefaultEntityByIdController extends AbstractController
{
    /**
     * @param QueryBus<DefaultEntity> $queryBus
     */
    #[BehatFeature(status: Status::SUCCESS, file: 'ById.feature', anchors: [
        'success',
    ])]
    #[BehatFeature(status: Status::FAILURE, file: 'ById.feature', anchors: [
        'failInvalidId',
    ])]
    #[Rest\View(statusCode: Response::HTTP_OK, serializerGroups: ['entity_default', 'response_dto_default'])]
    #[ApiDoc\Operation(['tags' => ['BFF']])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Get(summary: 'Get default entity', responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: 'Entity info',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        ref: new ApiDoc\Model(
                            type: DefaultEntity::class,
                            groups: ['entity_default', 'response_dto_default'],
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
        DefaultEntityByIdForm $form,
    ): DefaultEntity {
        return $queryBus->query(new DefaultEntityById($form->id));
    }
}
