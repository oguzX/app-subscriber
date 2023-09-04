<?php

namespace App\Service\Decorater;

use App\Entity\Device;
use App\Type\RegisterType;

class DeviceDecorator
{
    /**
     * @param RegisterType $registerType
     * @return Device
     */
    public function RegisterTypeToDevice(RegisterType $registerType): Device
    {
        $device = new Device();
        $device->setUid($registerType->getUid());
        $device->setAppId($registerType->getAppId());
        $device->setLanguage($registerType->getLanguage());
        $device->setOperatingSystem($registerType->getOperatingSystem());
        $device->setApplication($registerType->getApplication());

        return $device;
    }
}