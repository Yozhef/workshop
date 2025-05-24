<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\Homework\Form;

use App\Domain\Entity\Homework;
use App\Infrastructure\Validator\Constraints\EntityUnique;
use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class HomeworkCreateForm extends AbstractFormType
{
    public Uuid $id;
    public string $name;
    public ?string $description = null;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', UuidType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new EntityUnique(options: ['entityClass' => Homework::class]),
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ]);
    }
}
