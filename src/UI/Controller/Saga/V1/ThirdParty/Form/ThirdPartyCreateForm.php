<?php

declare(strict_types=1);

namespace App\UI\Controller\Saga\V1\ThirdParty\Form;

use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ThirdPartyCreateForm extends AbstractFormType
{
    public string $event;
    public string $email;
    public ?string $language = null;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('event', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ])
            ->add('language', TextType::class, options: [
                'required' => false,
                'constraints' => [
                    new Assert\Type(type: 'string', message: self::STRING),
                ],
            ]);
    }
}
