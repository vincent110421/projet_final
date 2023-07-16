<?php

namespace App\Entity;

use App\Repository\ServiceCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceCardRepository::class)]
class ServiceCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(length: 15)]
    private ?string $titleColor = null;

    #[ORM\Column(length: 15)]
    private ?string $contentColor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTitleColor(): ?string
    {
        return $this->titleColor;
    }

    public function setTitleColor(string $titleColor): static
    {
        $this->titleColor = $titleColor;

        return $this;
    }

    public function getContentColor(): ?string
    {
        return $this->contentColor;
    }

    public function setContentColor(string $contentColor): static
    {
        $this->contentColor = $contentColor;

        return $this;
    }
}
