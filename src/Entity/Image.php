<?php

namespace App\Entity;

use App\Entity\BaseEntity;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Types\UuidType;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image extends BaseEntity
{
    #[ORM\Column(length: 128, nullable: true)]
    #[Assert\Regex('/^[\w\s.-]+$/', 'Only letters and numbers allowed')]
    private ?string $title = null;

    #[ORM\Column(length: 128)]
    private ?string $context = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(type: UuidType::NAME)]
    private ?string $entityId = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Entity title image is related to.
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * Entity title image is related to.
     */
    public function setContext(?string $context): static
    {
        $this->context = $context;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * ID of the context if available
     */
    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    public function setEntityId(string $entityId): static
    {
        $this->entityId = $entityId;

        return $this;
    }
}
