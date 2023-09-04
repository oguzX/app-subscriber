<?php

namespace App\EventListener;

use App\Entity\Subscription;
use App\Service\Callback\SubscriptionCallbackService;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Log\LoggerInterface;

class SubscriptionChangeListener
{

    private SubscriptionCallbackService $subscriptionCallbackService;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, SubscriptionCallbackService $subscriptionCallbackService)
    {
        $this->subscriptionCallbackService = $subscriptionCallbackService;
        $this->logger = $logger;
    }

    public function postUpdate(Subscription $subscription, LifecycleEventArgs $event)
    {
        $uow = $event->getEntityManager()->getUnitOfWork();

        $changes = $uow->getEntityChangeSet($subscription);

        try{
            foreach ($changes as $property => $change) {
                switch ($property){
                    case 'status':
                        if(Subscription::STATUS_PASSIVE == $change[1]){
                            $this->canceledRequest($subscription);
                        }
                        break;
                    case 'expireDate':
                        $this->renewedRequest($subscription);
                        break;
                }
            }
        }catch (\Exception $exception){
            $this->logger->error($exception->getMessage());
        }
    }

    public function startedRequest(Subscription $subscription)
    {
        $this->subscriptionCallbackService->started($subscription);
    }

    public function renewedRequest(Subscription $subscription)
    {
        $this->subscriptionCallbackService->started($subscription);
    }

    public function canceledRequest(Subscription $subscription)
    {
        $this->subscriptionCallbackService->started($subscription);
    }
}