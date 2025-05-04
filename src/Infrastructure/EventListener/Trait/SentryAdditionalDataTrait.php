<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Trait;

use App\Domain\Exception\ExtraParamsExceptionInterface;
use Sentry\SentrySdk;
use Sentry\State\Scope;
use Throwable;

trait SentryAdditionalDataTrait
{
    public function addSentryAdditionalData(Throwable $exception, bool $capture = false): void
    {
        if (!$exception instanceof ExtraParamsExceptionInterface) {
            return;
        }

        SentrySdk::getCurrentHub()->configureScope(static function (Scope $scope) use ($exception, $capture): void {
            $scope->setExtras([
                $exception->getKeyName() => $exception->getParams(),
            ]);

            if ($capture) {
                SentrySdk::getCurrentHub()->captureException($exception);
            }
        });
    }
}
