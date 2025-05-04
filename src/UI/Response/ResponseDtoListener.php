<?php

declare(strict_types=1);

namespace App\UI\Response;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener]
final class ResponseDtoListener implements EventSubscriberInterface
{
    public function __construct(private readonly bool $isSkipped = false)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 50],
        ];
    }

    public function onKernelView(ViewEvent $event): void
    {
        $payload = $event->getControllerResult();

        if ($this->isSkipped || $payload === null || $payload instanceof ResponseInterface) {
            return;
        }

        if ($payload instanceof Paginator) {
            $dto = new PaginatedResponseDto(
                $payload,
                (int) $payload->getQuery()->getMaxResults(),
                $payload->getQuery()->getFirstResult(),
            );
        } elseif (is_iterable($payload)) {
            $dto = new ListResponseDto($payload);
        } elseif (is_object($payload)) {
            $dto = new ResponseDto($payload);
        } else {
            throw new InvalidResponseDataTypeException($payload);
        }

        $event->setControllerResult($dto);
    }
}
