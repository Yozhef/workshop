<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\HomeWork\Form;

use App\Domain\Entity\HomeWork;
use App\Infrastructure\Validator\Constraints\EntityReference;
use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class HomeWorkUpdateForm extends AbstractFormType
{
    public Uuid $id;
    public string $title;
    public \DateTimeImmutable $dueDate;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', UuidType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new EntityReference(options: ['entityClass' => HomeWork::class]),
                ],
            ])
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ])
            ->add('dueDate', DateTimeType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                ],
            ]);
    }
}
