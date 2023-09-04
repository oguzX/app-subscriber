<?php

namespace App\Type;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseType
{
    #[Assert\NotBlank]
    private ?string $receipt = null;

    /**
     * @return string|null
     */
    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    /**
     * @param string|null $receipt
     */
    public function setReceipt(?string $receipt): void
    {
        $this->receipt = $receipt;
    }


}