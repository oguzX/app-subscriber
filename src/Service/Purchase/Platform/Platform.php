<?php

namespace App\Service\Purchase\Platform;

class Platform
{
    public function request($receipt): bool
    {
        $lastChar = substr($receipt, -1);

        return $lastChar % 2 !== 0;
    }
}