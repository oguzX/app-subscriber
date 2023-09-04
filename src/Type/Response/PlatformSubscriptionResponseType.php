<?php

namespace App\Type;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseType
{
    #[Assert\NotBlank]
    private ?string $receipt = null;
}