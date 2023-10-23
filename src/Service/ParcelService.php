<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\Dimensions;
use App\Entity\FullName;
use App\Entity\Parcel;
use App\Entity\Recipient;
use App\Entity\Sender;
use App\Repository\ParcelRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParcelService
{
    private EntityManagerInterface $entityManager;
    private ParcelRepository $parcelRepository;

    public function __construct(EntityManagerInterface $entityManager, ParcelRepository $parcelRepository)
    {
        $this->entityManager = $entityManager;
        $this->parcelRepository = $parcelRepository;
    }

    public function createParcel(array $data): Parcel
    {
        $senderFullName = new FullName(
            $data['sender']['fullName']['firstName'],
            $data['sender']['fullName']['lastName'],
            $data['sender']['fullName']['middleName'],
        );
        $senderAddress = new Address(
            $data['sender']['address']['country'],
            $data['sender']['address']['city'],
            $data['sender']['address']['street'],
            $data['sender']['address']['house'],
            $data['sender']['address']['apartment'],
        );
        $sender = new Sender($senderFullName, $data['sender']['phone'], $senderAddress);
        $recipientFullName = new FullName(
            $data['recipient']['fullName']['firstName'],
            $data['recipient']['fullName']['lastName'],
            $data['recipient']['fullName']['middleName'],
        );
        $recipientAddress = new Address(
            $data['recipient']['address']['country'],
            $data['recipient']['address']['city'],
            $data['recipient']['address']['street'],
            $data['recipient']['address']['house'],
            $data['recipient']['address']['apartment'],
        );
        $recipient = new Recipient($recipientFullName, $data['recipient']['phone'], $recipientAddress);
        $dimensions = new Dimensions(
            $data['dimensions']['weight'],
            $data['dimensions']['length'],
            $data['dimensions']['height'],
            $data['dimensions']['width'],
        );
        $parcel = new Parcel(
            $sender,
            $recipient,
            $dimensions,
            $data['estimatedCost']
        );
        $this->entityManager->persist($parcel);
        $this->entityManager->flush();

        return $parcel;
    }

    public function search(string $searchType, string $q): array
    {
        if ($searchType === 'sender_phone') {
            $results = $this->parcelRepository->findBySenderPhone($q);
        } else {
            $results = $this->parcelRepository->findByRecipientName($q);
        }
        if (empty($results)) {
            return ['message' => 'Ничего не найдено'];
        }
        $parcels = [];
        foreach ($results as $result) {
            $parcels[] = $result->toArray();
        }

        return $parcels;
    }

    public function deleteParcel(string $id): string
    {
        $parcel = $this->parcelRepository->findOneBy(['id' => $id]);
        if ($parcel) {
            $this->entityManager->remove($parcel);
            $this->entityManager->flush();

            return "Посылка №$id удалена";
        }

        return 'Посылка не нашлась';
    }
}
