<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\PinCode\Form;

use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class PinCodeCreateForm extends AbstractFormType
{
    public Uuid $token;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('token', UuidType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                ],
            ]);
    }
}
