<?php

namespace App\Service\Purchase\Platform;

class Google extends Platform
{
    public function approveReceipt($receipt): \App\Type\Response\PlatformSubscriptionResponseType
    {
        return $this->request($receipt);
    }
}