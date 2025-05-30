<?php

declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\HomeworkEntity\Form;

use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class HomeworkEntityPaginatedListForm extends AbstractFormType
{
    public int $limit;
    public int $offset;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('limit', IntegerType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'int', message: self::INTEGER),
                    new Assert\GreaterThan(value: '0', message: self::GREATER_THAN),
                ],
            ])
            ->add('offset', IntegerType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'int', message: self::INTEGER),
                    new Assert\GreaterThanOrEqual(value: '0', message: self::GREATER_THAN_EQUAL),
                ],
            ]);
    }
}
