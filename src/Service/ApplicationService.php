<?php

namespace App\Service;


use App\Entity\Application;
use App\Entity\Device;
use App\Entity\DeviceToken;
use App\Service\Decorater\DeviceDecorator;
use App\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

class ApplicationService{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function getApplicationByAppId($appId)
    {
        return $this->entityManager->getRepository(Application::class)->findOneBy(['app_id' => $appId]);
    }

}
