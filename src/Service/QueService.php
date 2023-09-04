<?php

namespace App\Service;


use App\Entity\Subscription;
use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
use Enqueue\Util\JSON;

class QueService
{

    private ProducerInterface $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    public function subscriberRefresh(Subscription $subscription)
    {
        $serialized = JSON::encode([
            'id'=> $subscription->getId()
        ]);
        $message = new Message($serialized);
        return  $this->producer->sendCommand('subscriber_refresher_topic', $message);
    }


}


