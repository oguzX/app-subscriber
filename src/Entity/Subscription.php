<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\SubscriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Subscription
{
    use TimeStampableTrait;

    const STATUS_PASSIVE = 'passive';
    const STATUS_ACTIVE = 'active';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["api"])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Device $device = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["api"])]
    private ?\DateTimeInterface $expireDate = null;

    #[ORM\Column(length: 10)]
    #[Groups(["api"])]
    private ?string $status = null;

    #[ORM\Column(length: 10)]
    #[Groups(["api"])]
    private ?string $platform = null;

    #[ORM\Column(length: 100)]
    private ?string $receipt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): static
    {
        $this->device = $device;

        return $this;
    }

    public function getExpireDate(): ?\DateTimeInterface
    {
        return $this->expireDate;
    }

    public function setExpireDate(\DateTimeInterface $expireDate): static
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): static
    {
        $this->platform = $platform;

        return $this;
    }

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): static
    {
        $this->receipt = $receipt;

        return $this;
    }
}
