<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\DeviceToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeviceToken>
 *
 * @method DeviceToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeviceToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeviceToken[]    findAll()
 * @method DeviceToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeviceToken::class);
    }
}
