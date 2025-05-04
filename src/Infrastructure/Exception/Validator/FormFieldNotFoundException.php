<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception\Validator;

use App\Domain\Exception\AbstractException;
use Symfony\Component\HttpFoundation\Response;

class FormFieldNotFoundException extends AbstractException
{
    public function __construct(
        string $pathName,
        string $notFoundPart,
    ) {
        parent::__construct(
            'form.validation.fieldNotFound',
            [
                'pathName' => $pathName,
                'notFountPartName' => $notFoundPart,
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }
}
