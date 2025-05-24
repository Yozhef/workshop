<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Attribute as Serializer;

#[ORM\Table(name: 'homework')]
#[ORM\Entity]
class Homework
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[Serializer\Groups(groups: ['entity_default'])]
    private string $id;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Serializer\Groups(groups: ['entity_default'])]
    private ?string $name;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Serializer\Groups(groups: ['entity_default'])]
    private ?string $description;

    public function __construct(Uuid $id, string $name, ?string $description = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }
}