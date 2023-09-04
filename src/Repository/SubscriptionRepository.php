<?php

namespace App\Repository;

use App\Entity\Device;
use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subscription>
 *
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getSubscriptionByReceipt(Device $device, string $receipt)
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.device = :device')
            ->andWhere('s.receipt = :receipt')
            ->setParameters([
                'device' => $device,
                'receipt' => $receipt
            ])
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getSubscriptionByDevice(Device $device)
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.device = :device')
            ->setParameters([
                'device' => $device
            ])
            ->orderBy('s.createdAt', 'desc')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return Device[]
     */
    public function getActiveExpiredSubscriptions()
    {
        $qb = $this->createQueryBuilder('s')
            ->andWhere('s.expireDate <= :now')
            ->andWhere('s.status = :status')
            ->setParameters([
                'now' => new \DateTime(),
                'status' => 'active'
            ])
        ;

        return $qb->getQuery()->getResult();
    }
}
