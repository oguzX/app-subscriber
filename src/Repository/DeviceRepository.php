<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\DeviceToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Device>
 *
 * @method Device|null find($id, $lockMode = null, $lockVersion = null)
 * @method Device|null findOneBy(array $criteria, array $orderBy = null)
 * @method Device[]    findAll()
 * @method Device[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeviceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Device::class);
    }

    public function getDeviceByToken($token)
    {
        $qb = $this->createQueryBuilder('d')
            ->leftJoin(DeviceToken::class, 'dt','WITH', 'dt.token = :token and dt.device = d')
            ->setParameter('token', $token)
            ->orderBy('dt.id', 'desc')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
