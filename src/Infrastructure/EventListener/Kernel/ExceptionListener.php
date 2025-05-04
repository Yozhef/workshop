<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Kernel;

use App\Domain\Exception\AbstractException;
use App\Domain\Exception\ParameterExceptionInterface;
use App\Infrastructure\EventListener\Trait\SentryAdditionalDataTrait;
use Doctrine\DBAL\Exception\ConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Uid\Uuid;
use Throwable;
use Doctrine\DBAL\Query;

class ExceptionListener implements EventSubscriberInterface
{
    use SentryAdditionalDataTrait;

    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', 10],
            ],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        while ($exception instanceof HandlerFailedException) {
            $wrappedExceptions = $exception->getWrappedExceptions();
            $exception = reset($wrappedExceptions);
        }

        assert($exception instanceof Throwable);
        $this->addSentryAdditionalData($exception);

        $errorUuid = Uuid::v4();
        $parameters = ($exception instanceof ParameterExceptionInterface) ? $exception->getParameters() : [];

        if ($exception instanceof HttpExceptionInterface) {
            $event->setResponse(
                $this->createErrorResponse(
                    $exception->getMessage(),
                    $exception->getStatusCode(),
                    $parameters,
                ),
            );

            return;
        }

        if ($exception instanceof UniqueConstraintViolationException) {
            $message = $exception->getMessage();
            $conflictingFields = $this->extractConflictingFieldsAndValues($message);
            $tableName = $this->extractTableNameFromQuery($exception->getQuery());

            $event->setResponse(
                $this->createErrorResponse(
                    sprintf('%s.invalid', $tableName),
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    $conflictingFields,
                ),
            );

            return;
        }

        if ($exception instanceof ConstraintViolationException) {
            $event->setResponse(
                $this->createErrorResponse(
                    'async.request.or.not.validate',
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                ),
            );

            return;
        }

        if ($exception instanceof AbstractException) {
            $event->setResponse(
                $this->createErrorResponse(
                    $exception->getMessage(),
                    $exception->getCode(),
                    $parameters,
                ),
            );

            return;
        }

        if ($exception instanceof AccessDeniedException) {
            return;
        }

        /** @var object|Throwable $exception */
        $exceptionClassName = get_class($exception);

        $this->logger->error($exceptionClassName, [
            'parameters' => ['errorUuid' => $errorUuid],
            'exception' => $exception,
        ]);

        $event->setResponse(
            $this->createErrorResponse(
                'errors.general',
                500,
                ['errorUuid' => $errorUuid],
            ),
        );
    }

    /** @param array<int|string, mixed> $params */
    private function createErrorResponse(string $message, int $code, array $params = []): JsonResponse
    {
        return $this->createJsonResponse('Http Exception', $code, [['code' => $message]], $params);
    }

    /**
     * @param array<int|string, mixed> $errors
     * @param array<int|string, mixed> $params
     */
    private function createJsonResponse(string $message, int $code, array $errors, ?array $params = null): JsonResponse
    {
        $code = $this->isHttpErrorCodeInvalid($code) ? Response::HTTP_INTERNAL_SERVER_ERROR : $code;
        $params = (!is_array($params) || count($params) <= 0) ? null : $params;

        return new JsonResponse([
            'code' => (string)$code,
            'message' => $message,
            'errors' => $errors,
            'params' => $params,
        ], $code);
    }

    /**
     * This method copied from here \Symfony\Component\HttpFoundation\Response::isInvalid
     */
    private function isHttpErrorCodeInvalid(int $code): bool
    {
        return $code < 100 || $code >= 600;
    }

    /**
     * @return array<string, string>
     */
    private function extractConflictingFieldsAndValues(string $message): array
    {
        $pattern = '/Key \((.*?)\)=\((.*?)\) already exists/';

        preg_match($pattern, $message, $matches);

        $fields = $matches[1] ?? '';
        $values = $matches[2] ?? '';

        $explodedFields = explode(', ', $fields);
        $explodedValues = explode(', ', $values);

        $conflictingFieldsAndValues = array_combine($explodedFields, $explodedValues);

        $camelCaseArray = [];
        foreach ($conflictingFieldsAndValues as $key => $value) {
            $camelCaseKey = $this->convertSnakeCaseToCamelCase($key);
            $camelCaseArray[$camelCaseKey] = $value;
        }

        return $camelCaseArray;
    }

    private function extractTableNameFromQuery(?Query $query): string
    {
        if (!$query instanceof Query) {
            return '';
        }

        $sql = $query->getSQL();

        $pattern = '/(?:INSERT INTO|UPDATE) (\w+)/';

        preg_match($pattern, $sql, $matches);

        if (!array_key_exists(1, $matches) || (0 === count($matches))) {
            return '';
        }

        return $this->convertSnakeCaseToCamelCase($matches[1]);
    }

    private function convertSnakeCaseToCamelCase(string $value): string
    {
        return lcfirst(
            str_replace(
                ' ',
                '',
                ucwords(
                    str_replace('_', ' ', $value),
                ),
            ),
        );
    }
}
