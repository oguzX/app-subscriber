<?php

namespace App\Service;


use App\Entity\Device;
use App\Service\Decorater\DeviceDecorator;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

class DeviceService{

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
     * @param RegisterType $registerType
     * @return Device|null
     */
    public function register(RegisterType $registerType)
    {
        $device = $this->getDevice($registerType);
        if ($device){
            return $device;
        }

        return $this->sigup($registerType);
    }

    private function getDevice(RegisterType $registerType)
    {
        return $this->entityManager->getRepository(Device::class)->findOneBy(['uid' => $registerType->getUid(), 'appId' => $registerType->getAppId()]);;
    }

    private function sigup(RegisterType $registerType)
    {
        $device = $this->deviceDecorator->RegisterTypeToDevice($registerType);

        $this->entityManager->persist($device);
        $this->entityManager->flush();

        return $device;
    }
}
