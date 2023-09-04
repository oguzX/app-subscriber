<?php

namespace App\EventListener;

use App\Entity\Subscription;
use App\Service\Callback\SubscriptionCallbackService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SubscriptionChangeListener
{

    private SubscriptionCallbackService $subscriptionCallbackService;

    public function __construct(SubscriptionCallbackService $subscriptionCallbackService)
    {
        $this->subscriptionCallbackService = $subscriptionCallbackService;
    }

    public function postUpdate(Subscription $subscription, LifecycleEventArgs $event)
    {
        $uow = $event->getEntityManager()->getUnitOfWork();

        $changes = $uow->getEntityChangeSet($subscription);
        dd($changes);
        foreach ($changes as $property => $change) {
            switch ($property){
                case 'expireDate':
                    break;
                case 'status':
                    break;
                case '':
                    break;
            }
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