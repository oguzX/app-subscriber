<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class ApiKeyUser implements UserInterface
{
    private ?int $uid = null;
    private ?string $appId = null;
    private ?string $token;
    private ?string $operatingSystem;
    private ?array $roles = [];

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
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
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

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function eraseCredentials():void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->uid;
    }
}