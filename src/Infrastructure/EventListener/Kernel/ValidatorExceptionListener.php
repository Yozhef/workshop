<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Kernel;

use App\Domain\Exception\Validator\InvalidParamsDtoException as DomainInvalidParamsDtoException;
use App\Domain\Exception\Validator\InvalidParamsException as DomainInvalidParamsException;
use App\Infrastructure\EventListener\Trait\SentryAdditionalDataTrait;
use ReflectionClass;
use ReflectionException;
use RequestDtoResolver\Exception\InvalidParamsDtoException;
use RequestDtoResolver\Exception\InvalidParamsException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Throwable;

class ValidatorExceptionListener implements EventSubscriberInterface
{
    use SentryAdditionalDataTrait;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onValidatorException', 300],
        ];
    }

    /**
     * @throws ReflectionException
     */
    public function onValidatorException(ExceptionEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $exception = $event->getThrowable();
        while ($exception instanceof HandlerFailedException) {
            $wrappedExceptions = $exception->getWrappedExceptions();
            $exception = reset($wrappedExceptions);
        }

        assert($exception instanceof Throwable);
        $this->addSentryAdditionalData($exception);

        if (
            !$exception instanceof InvalidParamsException &&
            !$exception instanceof DomainInvalidParamsException &&
            !$exception instanceof ValidationFailedException
        ) {
            return;
        }

        $prefix = null;
        if (
            $exception instanceof InvalidParamsDtoException ||
            $exception instanceof DomainInvalidParamsDtoException
        ) {
            /** @var class-string $dtoClassName */
            $dtoClassName = $exception->getDtoClassName();

            $reflection = new ReflectionClass($dtoClassName);

            $prefix = lcfirst($reflection->getShortName());
        }

        $errors = [];
        if (
            $exception instanceof InvalidParamsException ||
            $exception instanceof DomainInvalidParamsException
        ) {
            $errors = $this->mapValidationErrors(
                $this->convertConstraintViolationListToArray($exception->getList(), $prefix),
            );
        } elseif ($exception instanceof ValidationFailedException) {
            $errors = $this->mapValidationErrors(
                $this->convertConstraintViolationListToArray($exception->getViolations(), $prefix),
            );
        }

        if (0 === count($errors)) {
            return;
        }

        $response = $this->createResponse($errors);
        $event->setResponse($response);
    }

    /**
     * @param array{
     *     code: string,
     *     message: string,
     *     errors: array<int, array{code: string, path: string}>,
     *     params: mixed
     * } $errors
     */
    private function createResponse(array $errors): JsonResponse
    {
        return new JsonResponse($errors, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param array<int<0, max>, array{code: string, path: string}> $errors
     *
     * @return array{
     *     code: string,
     *     message: string,
     *     errors: array<int<0, max>, array{code: string, path: string}>,
     *     params: mixed
     * }
     */
    private function mapValidationErrors(array $errors): array
    {
        return [
            'code' => (string)Response::HTTP_BAD_REQUEST,
            'message' => 'Validation Failed',
            'errors' => $errors,
            'params' => null,
        ];
    }

    /** @return array<int<0, max>, array{code: string, path: string}> */
    private function convertConstraintViolationListToArray(
        ConstraintViolationListInterface $violationList,
        ?string $prefix = null,
    ): array {
        $errors = [];
        foreach ($violationList as $violation) {
            $errors[] = $this->formatViolation($violation, $prefix);
        }

        return $errors;
    }

    /**
     * @return array{code: string, path: string}
     */
    private function formatViolation(ConstraintViolationInterface $violation, ?string $prefix = null): array
    {
        $propertyPath = $this->normalizeProperty($violation->getPropertyPath());
        $code = $this->getCode($violation, $propertyPath, $prefix);

        return [
            'code' => $this->normalizeProperty($code),
            'path' => $this->normalizePropertyPath($propertyPath),
        ];
    }

    private function getCode(
        ConstraintViolationInterface $violation,
        string $propertyPath,
        ?string $prefix = null,
    ): string {
        $code = [];
        if ($prefix !== null) {
            $code[] = $prefix;
        }
        $code[] = $propertyPath;
        $code[] = $violation->getMessage();

        return implode('.', $code);
    }

    private function normalizePropertyPath(string $propertyPath): string
    {
        return str_replace(['][', '[', ']'], ['.', ''], $propertyPath);
    }

    private function normalizeProperty(string $path): string
    {
        $normalizedPath = preg_replace(
            [
                '/children\[(.*?)?]/',
                '/\[([\d]*?)]/',
                '/.data/',
                '/](.*?)?\[/',
            ],
            [
                '$1',
                '.$1',
                '',
            ],
            $path,
        );

        return $normalizedPath !== null ? $normalizedPath : $path;
    }
}
