<?php

namespace App\Service\Callback;


use App\Service\Decorater\DeviceDecorator;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;

class CallbackService{

    private EntityManagerInterface $entityManager;
    private DeviceDecorator $deviceDecorator;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceDecorator $deviceDecorator
    )
    {
        $this->entityManager = $entityManager;
        $this->deviceDecorator = $deviceDecorator;
    }

    /**
     * @return string
     */
    public function request($url,$data,$method = 'POST')
    {
        $client = new Client();
        $request = $client->request($method, $url, [
           'json' => $data
        ]);

        return $request->getBody()->getContents();
    }

}
