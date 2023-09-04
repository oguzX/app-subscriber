<?php

namespace App\Service\Purchase\Platform;

class Apple extends Platform
{
    public function approveReceipt($receipt): \App\Type\Response\PlatformSubscriptionResponseType
    {
        return $this->request($receipt);
    }
}