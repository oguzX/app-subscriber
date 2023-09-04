<?php

namespace App\Service\Security;


use App\Entity\Device;
use App\Entity\DeviceToken;
use App\Repository\DeviceTokenRepository;
use App\Service\DeviceService;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

class LoginService{

    private EntityManagerInterface $entityManager;
    private DeviceService $deviceService;
    private JwtService $jwtService;
    private DeviceTokenRepository $deviceTokenRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceService $deviceService,
        JwtService $jwtService,
        DeviceTokenRepository $deviceTokenRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->deviceService = $deviceService;
        $this->jwtService = $jwtService;
        $this->deviceTokenRepository = $deviceTokenRepository;
    }

    public function login(RegisterType $registerType)
    {
        $device = $this->deviceService->register($registerType);
        $deviceToken = $this->createOrUpdateToken($device);

        return $deviceToken->getToken();
    }

    private function createOrUpdateToken(Device $device): ?DeviceToken
    {
        list($token, $expireDate) = $this->jwtService->deviceJWTGenerate($device);
        $deviceToken = $this->deviceTokenRepository->findOneBy(['device' => $device]);

        if (!$deviceToken){
            $deviceToken = new DeviceToken();
            $deviceToken->setDevice($device);
            $deviceToken->setCreatedAt(new \DateTimeImmutable());
        }

        $deviceToken->setToken($token);
        $deviceToken->setExpireDate($expireDate);
        $deviceToken->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($deviceToken);
        $this->entityManager->flush();

        return $deviceToken;
    }

}
