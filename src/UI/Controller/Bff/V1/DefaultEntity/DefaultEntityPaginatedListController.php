<?php

declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\DefaultEntity;

use App\Application\Query\DefaultEntity\DefaultEntityPaginatedList;
use App\Domain\Entity\DefaultEntity;
use App\Infrastructure\MessageBus\QueryBus;
use App\UI\Controller\Bff\V1\DefaultEntity\Form\DefaultEntityPaginatedListForm;
use App\UI\Response\Model\PaginationModel;
use BehatNelmioDescriber\Attributes\BehatFeature;
use BehatNelmioDescriber\Attributes\BehatFeaturesPath;
use BehatNelmioDescriber\Enum\Status;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation as ApiDoc;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/api/bff/v1/default-entity-paginated',
    name: 'api_bff_v1_default_entity_paginated_list',
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_GET],
)]
#[BehatFeaturesPath(path: 'Api/Bff/V1/DefaultEntity/')]
final class DefaultEntityPaginatedListController extends AbstractController
{
    /**
     * @param QueryBus<Paginator> $queryBus
     */
    #[BehatFeature(status: Status::SUCCESS, file: 'PaginatedList.feature', anchors: [
        'success',
    ])]
    #[BehatFeature(status: Status::FAILURE, file: 'PaginatedList.feature', anchors: [
        'failInvalidParamsNotInteger',
        'failInvalidParamsNotPositive',
    ])]
    #[Rest\View(
        statusCode: Response::HTTP_OK,
        serializerGroups: [
            'entity_default',
            'pagination_default',
            'response_dto_default',
        ],
    )]
    #[ApiDoc\Operation(['tags' => ['BFF']])]
    #[OA\Parameter(name: 'limit', in: 'query', required: true, schema: new OA\Schema(type: 'integer', default: 10))]
    #[OA\Parameter(name: 'offset', in: 'query', required: true, schema: new OA\Schema(type: 'integer', default: 0))]
    #[OA\Get(responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: 'Successful response',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        description: 'List of entities',
                        type: 'array',
                        items: new OA\Items(
                            ref: new ApiDoc\Model(
                                type: DefaultEntity::class,
                                groups: ['entity_default', 'response_dto_default'],
                            ),
                        ),
                    ),
                    new OA\Property(
                        property: 'pagination',
                        ref: new ApiDoc\Model(
                            type: PaginationModel::class,
                            groups: ['pagination_default'],
                        ),
                        type: 'object',
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
        DefaultEntityPaginatedListForm $form,
    ): Paginator {
        return $queryBus->query(new DefaultEntityPaginatedList($form->limit, $form->offset));
    }
}
