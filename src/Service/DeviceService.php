<?php

namespace App\Service;


use App\Entity\Device;
use App\Entity\DeviceToken;
use App\Service\Decorater\DeviceDecorator;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\InvalidArgumentException;

class DeviceService{

    private EntityManagerInterface $entityManager;
    private DeviceDecorator $deviceDecorator;
    private ApplicationService $applicationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        DeviceDecorator $deviceDecorator,
        ApplicationService $applicationService
    )
    {
        $this->entityManager = $entityManager;
        $this->deviceDecorator = $deviceDecorator;
        $this->applicationService = $applicationService;
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
        return $this->entityManager->getRepository(Device::class)->findOneBy(['uid' => $registerType->getUid(), 'appId' => $registerType->getAppId()]);
    }

    public function getDeviceByToken($token): mixed
    {
        $device = $this->entityManager->getRepository(Device::class)->getDeviceByToken($token);
        if (!$device){
            throw new \Exception('TOKEN_NOT_VALID');
        }

        return $device;
    }

    private function sigup(RegisterType $registerType)
    {
        $application = $this->applicationService->getApplicationByAppId($registerType->getAppId());
        if (!$application){
            throw new InvalidArgumentException('APPLICATION_NOT_FOUNT');
        }
        $registerType->setApplication($application);

        $device = $this->deviceDecorator->RegisterTypeToDevice($registerType);


        $this->entityManager->persist($device);
        $this->entityManager->flush();

        return $device;
    }

}
