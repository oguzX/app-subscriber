<?php

namespace App\Service\Purchase\Platform;

use App\Exception\RateLimitExceededException;
use App\Type\Response\PlatformSubscriptionResponseType;

abstract class Platform
{
    abstract function approveReceipt(string $receipt);

    protected function request($receipt): PlatformSubscriptionResponseType
    {
        $lastChar = substr($receipt, -1);
        $lastTwoChar = substr($receipt, -2);
        if ($lastTwoChar % 6 == 0){
            throw new RateLimitExceededException('RATELIMIT_EXCEEDED');
        }

        $platformSubscriptionResponse = new PlatformSubscriptionResponseType();

        $platformSubscriptionResponse->status = $lastChar % 2 !== 0 ? 'active' : 'passive';


        $platformSubscriptionResponse->expireDate = (new \DateTime('now',  new \DateTimeZone('-06:00')))->modify('+6 months');

        return $platformSubscriptionResponse;
    }
}