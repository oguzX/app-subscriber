<?php

namespace App\Service\Security;


use App\Entity\Device;
use App\Service\DeviceService;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JwtService{

    private EntityManagerInterface $entityManager;
    private DeviceService $deviceService;
    private ParameterBagInterface $parameterBag;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceService $deviceService,
        ParameterBagInterface $parameterBag
    )
    {
        $this->entityManager = $entityManager;
        $this->deviceService = $deviceService;
        $this->parameterBag = $parameterBag;
    }

    public function deviceJWTGenerate(Device $device)
    {
        $dateTime = new \DateTime();
        $expireTime = $dateTime->modify('+30 minutes');
        $userData = [
            'uId' => $device->getUid(),
            'appId' => $device->getAppId(),
            'operatingSystem' => $device->getOperatingSystem(),
            'expireTime' => $expireTime->getTimestamp()
        ];
        $secret = $this->parameterBag->get('auth_secret');

        return [JWT::encode($userData, $secret, 'HS256'), $expireTime];
    }
}
