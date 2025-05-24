<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute as Serializer;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'home_work')]
class HomeWork implements Timestampable
{
    use TimestampableEntity;

    #[Serializer\Groups(groups: ['home_work_default'])]
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[Serializer\Groups(groups: ['home_work_default'])]
    #[ORM\Column(type: 'string')]
    private string $title;

    #[Serializer\Groups(groups: ['home_work_default'])]
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $dueDate;

    #[Serializer\Groups(groups: ['home_work_default'])]
    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isCompleted = false;

    public function __construct(
        Uuid $id,
        string $title,
        DateTimeImmutable $dueDate,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->dueDate = $dueDate;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDueDate(): DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    public function complete(DateTimeImmutable $completeDate): void
    {
        if ($completeDate > $this->dueDate) {
            throw new \DomainException('Cannot complete outdated homework');
        }

        $this->isCompleted = true;
    }
}
