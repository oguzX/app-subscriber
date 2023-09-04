<?php

namespace App\Service\Purchase;

use App\Entity\Device;
use App\Entity\Subscription;
use App\Service\Purchase\Platform\Apple;
use App\Service\Purchase\Platform\Google;
use App\Type\Response\PlatformSubscriptionResponseType;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionService
{

    private EntityManagerInterface $entityManager;
    private Apple $appleService;
    private Google $googleService;

    public function __construct(
        EntityManagerInterface $entityManager,
        Apple $appleService,
        Google $googleService
    )
    {
        $this->entityManager = $entityManager;
        $this->appleService = $appleService;
        $this->googleService = $googleService;
    }

    public function deviceAppSubscription(Device $device, string $receipt): Subscription
    {
        if (Device::OP_IOS === $device->getOperatingSystem()){
            $subscription = $this->applePurchase($device, $receipt);
        }else{
            $subscription = $this->googlePurchase($device, $receipt);
        }

        return $subscription;
    }

    private function googlePurchase(Device $device, string $receipt): Subscription
    {
        $platformSubscriptionResponse = $this->googleService->approveReceipt($receipt);
        return $this->updateSubscription($device, $receipt, $platformSubscriptionResponse);
    }

    private function applePurchase(Device $device, string $receipt): Subscription
    {
        $platformSubscriptionResponse = $this->appleService->approveReceipt($receipt);
        return $this->updateSubscription($device, $receipt, $platformSubscriptionResponse);
    }

    /**
     * @param Device $device
     * @param string $receipt
     * @param PlatformSubscriptionResponseType $platformSubscriptionResponseType
     * @return Subscription
     */
    private function updateSubscription(Device $device, string $receipt, PlatformSubscriptionResponseType $platformSubscriptionResponseType): Subscription
    {
        if (!$platformSubscriptionResponseType->status){
            return false;
        }

        $subscription = $this->entityManager->getRepository(Subscription::class)->getSubscription($device, $receipt);
        if (!$subscription){
            $subscription = new Subscription();
            $subscription->setDevice($device);
            $subscription->setPlatform($device->getOperatingSystem());
        }

        $subscription->setStatus($platformSubscriptionResponseType->status);
        $subscription->setExpireDate($platformSubscriptionResponseType->expireDate);

        return $subscription;
    }
}