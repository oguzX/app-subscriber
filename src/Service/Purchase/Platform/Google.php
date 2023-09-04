<?php

namespace App\Service\Purchase\Platform;

class Apple extends Platform
{
    public function approveReceipt($receipt): bool
    {
        return $this->request($receipt);
    }
}