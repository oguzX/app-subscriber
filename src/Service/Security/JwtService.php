<?php

namespace App\Service\Security;


use App\Entity\Device;
use App\Service\DeviceService;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

class LoginService{

    private EntityManagerInterface $entityManager;
    private DeviceService $deviceService;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceService $deviceService
    )
    {
        $this->entityManager = $entityManager;
        $this->deviceService = $deviceService;
    }

    public function login(RegisterType $registerType)
    {
        $device = $this->deviceService->register($registerType);


    }

    private function jwtGenerator(Device $device){

    }
}
