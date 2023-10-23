<?php

namespace App\Repository;

use App\Entity\Parcel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parcel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcel[]    findAll()
 * @method Parcel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcel::class);
    }

    public function findBySenderPhone(string $phone): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sender.phone = :phone')
            ->setParameter('phone', $phone)
            ->getQuery()
            ->getResult();
    }

    public function findByRecipientName(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->where("CONCAT(p.recipient.fullName.firstName, ' ', p.recipient.fullName.lastName, ' ', p.recipient.fullName.middleName) = :name")
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
}
