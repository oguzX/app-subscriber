<?php

namespace App\Service;


use App\Type\ElasticProductUpdateType;
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

    public function add(array $data, string $command)
    {
        $serialized = JSON::encode($data);
        $message = new Message($serialized);
        return  $this->producer->sendCommand($command, $message);
    }

    public function addTopicWithId(string $eventName,$id)
    {
        $serialized = JSON::encode(array('id'=>$id));
        $message = new Message($serialized);
        $this->producer->sendEvent($eventName, $message);
    }



}


