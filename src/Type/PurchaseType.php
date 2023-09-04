<?php

namespace App\Type;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterType
{
    #[Assert\NotBlank]
    private ?int $uid = null;
    #[Assert\NotBlank]
    private ?string $appId = null;
    #[Assert\NotBlank]
    private ?string $language = null;
    #[Assert\NotBlank]
    private ?string $operatingSystem = null;

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @param int|null $uid
     */
    public function setUid(?int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string|null
     */
    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * @param string|null $appId
     */
    public function setAppId(?string $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     */
    public function setLanguage(?string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return string|null
     */
    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    /**
     * @param string|null $operatingSystem
     */
    public function setOperatingSystem(?string $operatingSystem): void
    {
        $this->operatingSystem = $operatingSystem;
    }
}