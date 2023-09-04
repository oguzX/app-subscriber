<?php

namespace App\EventListener;

use App\Entity\Subscription;
use App\Service\Callback\SubscriptionCallbackService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class SubscriptionStartedChangeListener
{

    private SubscriptionCallbackService $subscriptionCallbackService;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, SubscriptionCallbackService $subscriptionCallbackService)
    {
        $this->subscriptionCallbackService = $subscriptionCallbackService;
        $this->logger = $logger;
    }

    public function prePersist(Subscription $subscription, LifecycleEventArgs $event)
    {
        try{
            $this->startedRequest($subscription);
        }catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
        }
    }

    public function startedRequest(Subscription $subscription)
    {
        $this->subscriptionCallbackService->started($subscription);
    }

}