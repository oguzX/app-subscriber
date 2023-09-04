<?php

namespace App\Controller;

use App\Service\DeviceService;
use App\Service\Purchase\PurchaseService;
use App\Service\Purchase\SubscriptionService;
use App\Type\PurchaseType;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/subscription', name: 'app_api_subscription_')]
class SubscriptionController extends AbstractController
{
    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    #[ParamConverter('purchaseType', class: PurchaseType::class, converter: 'fos_rest.request_body')]
    #[View(serializerGroups: ["api"])]
    public function purchase(PurchaseType $purchaseType, SubscriptionService $subscriptionService, DeviceService $deviceService, ConstraintViolationListInterface $validationErrors)
    {
        if (\count($validationErrors) > 0) {
            return \FOS\RestBundle\View\View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $device = $deviceService->getDeviceByToken($this->getUser()->getToken());
        $subscription = $subscriptionService->deviceAppSubscription($device, $purchaseType->getReceipt());

        return $subscription;
    }

    #[Route('/check', name: 'check', methods: ['POST'])]
    #[View(serializerGroups: ["api"])]
    public function check(SubscriptionService $subscriptionService, DeviceService $deviceService)
    {
        $device = $deviceService->getDeviceByToken($this->getUser()->getToken());

        return $subscriptionService->getSubscription($device);
    }
}