<?php

namespace App\Processor;

use App\Entity\Subscription;
use App\Service\Purchase\SubscriptionService;
use Doctrine\ORM\EntityManagerInterface;
use Enqueue\Client\CommandSubscriberInterface;
use Enqueue\Util\JSON;
use Interop\Queue\Message;
use Interop\Queue\Context;
use Interop\Queue\Processor;

class SubscriberRefreshProcessor implements Processor, CommandSubscriberInterface
{

    private EntityManagerInterface $entityManager;
    private SubscriptionService $subscriptionService;

    public function __construct(EntityManagerInterface $entityManager, SubscriptionService $subscriptionService)
    {
        $this->entityManager = $entityManager;
        $this->subscriptionService = $subscriptionService;
    }

    public function process(Message $message, Context $session)
    {
        $message = JSON::decode($message->getBody());
        $subscription = $this->entityManager->getRepository(Subscription::class)->find($message['id']);
        $this->subscriptionService->deviceAppSubscription($subscription->getDevice(), $subscription->getReceipt());
        echo "#{$subscription->getId()} updated";

        return self::ACK;
    }

    public static function getSubscribedCommand(): array
    {
        return [
            'command' => 'subscriber_refresher_topic',
            'queue' => 'subscriber_refresher',
            'prefix_queue' => true,
            'exclusive' => false
        ];
    }
}