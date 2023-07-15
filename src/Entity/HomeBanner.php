<?php

namespace App\Entity;

use App\Repository\HomeBannerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HomeBannerRepository::class)]
class HomeBanner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $banner = null;

    #[ORM\Column(length: 80)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $titleColor = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $contentColor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(string $banner): static
    {
        $this->banner = $banner;

        return $this;
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

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getTitleColor(): ?string
    {
        return $this->titleColor;
    }

    public function setTitleColor(?string $titleColor): static
    {
        $this->titleColor = $titleColor;

        return $this;
    }

    public function getContentColor(): ?string
    {
        return $this->contentColor;
    }

    public function setContentColor(?string $contentColor): static
    {
        $this->contentColor = $contentColor;

        return $this;
    }
}
