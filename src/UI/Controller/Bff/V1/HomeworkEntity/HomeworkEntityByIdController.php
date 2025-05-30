<?php declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\HomeworkEntity;

use App\Application\Query\HomeworkEntity\HomeworkEntityById;
use App\Domain\Entity\HomeworkEntity;
use App\Infrastructure\MessageBus\QueryBus;
use App\UI\Controller\Bff\V1\HomeworkEntity\Form\HomeworkEntityByIdForm;
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
    path: '/api/bff/v1/homework-entity/{id}',
    name: 'api_bff_v1_homework_entity_by_id',
    requirements: ['id' => '[0-9a-fA-F\-]{36}'],
    defaults: ['_format' => 'json', 'anonymous' => true],
    methods: [Request::METHOD_GET],
)]
#[BehatFeaturesPath(path: 'Api/Bff/V1/HomeworkEntity/')]
final class HomeworkEntityByIdController extends AbstractController
{
    /**
     * @param QueryBus<HomeworkEntity> $queryBus
     */
    #[BehatFeature(status: Status::SUCCESS, file: 'ById.feature', anchors: [
        'success',
    ])]
    #[BehatFeature(status: Status::FAILURE, file: 'ById.feature', anchors: [
        'failInvalidId',
    ])]
    #[Rest\View(statusCode: Response::HTTP_OK, serializerGroups: ['entity_homework', 'response_dto_homework'])]
    #[ApiDoc\Operation(['tags' => ['BFF']])]
    #[OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'string'))]
    #[OA\Get(summary: 'Get homework entity', responses: [
        new OA\Response(
            response: Response::HTTP_OK,
            description: 'Entity info',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        ref: new ApiDoc\Model(
                            type: HomeworkEntity::class,
                            groups: ['entity_homework', 'response_dto_homework'],
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
        QueryBus               $queryBus,
        HomeworkEntityByIdForm $form,
    ): HomeworkEntity {
        return $queryBus->query(new HomeworkEntityById($form->id));
    }
}
