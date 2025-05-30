<?php declare(strict_types=1);

namespace App\UI\Controller\Bff\V1\HomeworkEntity\Form;

use App\Domain\Entity\HomeworkEntity;
use App\Infrastructure\Validator\Constraints\EntityReference;
use App\UI\Request\AbstractFormType;
use Symfony\Component\Form\Extension\Core\Type\UuidType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class HomeworkEntityByIdForm extends AbstractFormType
{
    public Uuid $id;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', UuidType::class, [
                'required' => true,
                'invalid_message' => self::INVALID,
                'constraints' => [
                    new Assert\NotBlank(message: self::NOT_BLANK),
                    new EntityReference(options: [
                        'entityClass' => HomeworkEntity::class,
                    ]),
                ],
            ]);
    }
}
