<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 100)]
    private ?string $app_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $callbackRenewed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $callbackStarted = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $callbackCanceled = null;

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

    public function getAppId(): ?string
    {
        return $this->app_id;
    }

    public function setAppId(string $app_id): static
    {
        $this->app_id = $app_id;

        return $this;
    }

    public function getCallbackRenewed(): ?string
    {
        return $this->callbackRenewed;
    }

    public function setCallbackRenewed(?string $callbackRenewed): static
    {
        $this->callbackRenewed = $callbackRenewed;

        return $this;
    }

    public function getCallbackStarted(): ?string
    {
        return $this->callbackStarted;
    }

    public function setCallbackStarted(?string $callbackStarted): static
    {
        $this->callbackStarted = $callbackStarted;

        return $this;
    }

    public function getCallbackCanceled(): ?string
    {
        return $this->callbackCanceled;
    }

    public function setCallbackCanceled(?string $callbackCanceled): static
    {
        $this->callbackCanceled = $callbackCanceled;

        return $this;
    }
}
