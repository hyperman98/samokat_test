<?php

namespace App\Tests\Unit;

use App\Entity\Address;
use App\Entity\Dimensions;
use App\Entity\FullName;
use App\Entity\Parcel;
use App\Entity\Recipient;
use App\Entity\Sender;
use App\Repository\ParcelRepository;
use App\Service\ParcelService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ParcelServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private ParcelRepository $parcelRepository;
    private ParcelService $parcelService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->parcelRepository = $this->createMock(ParcelRepository::class);
        $this->parcelService = new ParcelService($this->entityManager, $this->parcelRepository);
    }

    public function testCreateParcel()
    {
        $data = [
            'sender' => [
                'fullName' => [
                    'firstName' => 'Artyom',
                    'lastName' => 'Vadimovich',
                    'middleName' => 'Valiakhmetov',
                ],
                'address' => [
                    'country' => 'Russia',
                    'city' => 'Ekaterinburg',
                    'street' => 'Malysheva',
                    'house' => '144',
                    'apartment' => '509',
                ],
                'phone' => '+5234576890',
            ],
            'recipient' => [
                'fullName' => [
                    'firstName' => 'Nikolas',
                    'lastName' => 'Petrovich',
                    'middleName' => 'Cage',
                ],
                'address' => [
                    'country' => 'Russia',
                    'city' => 'Chelyabinsk',
                    'street' => 'Televisionnaya',
                    'house' => '3',
                    'apartment' => '105',
                ],
                'phone' => '+9876543210',
            ],
            'dimensions' => [
                'weight' => 15,
                'length' => 20,
                'height' => 15,
                'width' => 20,
            ],
            'estimatedCost' => 150,
        ];

        $parcel = $this->parcelService->createParcel($data);

        $this->assertInstanceOf(Parcel::class, $parcel);
        $this->assertInstanceOf(Sender::class, $parcel->getSender());
        $this->assertInstanceOf(Recipient::class, $parcel->getRecipient());
        $this->assertInstanceOf(Dimensions::class, $parcel->getDimensions());
        $this->assertEquals($data['estimatedCost'], $parcel->getEstimatedCost());
    }

    public function testSearchBySenderPhone()
    {
        $searchType = 'sender_phone';
        $q = '+852258741';

        $results = [
            new Parcel(
                new Sender(
                    new FullName('Ilya', 'Petrovich', 'Petrov'),
                    '+852258741',
                    new Address('Russia', 'Grozny', 'Kadyrova', '55', '55')
                ),
                new Recipient(
                    new FullName('Sergey', 'Sergeevich', 'Sergeev'),
                    '+8524458741',
                    new Address('Russia', 'Moskva', 'Lenina', '46', '2')
                ),
                new Dimensions(4, 4, 4, 4),
                4
            ),
            new Parcel(
                new Sender(
                    new FullName('Ilya', 'Petrovich', 'Petrov'),
                    '+852258741',
                    new Address('Russia', 'Grozny', 'Kadyrova', '55', '55')
                ),
                new Recipient(
                    new FullName('Nikolay', 'Nikolayevich', 'Nikolaev'),
                    '+7777777',
                    new Address('Russia', 'Irkutsk', 'Lenina', '1', '1')
                ),
                new Dimensions(5, 5, 5, 5),
                5
            ),
        ];
        $results[0]->setId('321');
        $results[1]->setId('322');

        $this->parcelRepository->expects($this->once())->method('findBySenderPhone')->with($q)->willReturn($results);

        $parcels = $this->parcelService->search($searchType, $q);

        $this->assertCount(2, $parcels);
    }

    public function testSearchByRecipientName()
    {
        $searchType = 'recipient_name';
        $q = 'Gaius Iulius Caesar';

        $results = [
            new Parcel(
                new Sender(
                    new FullName('Evgeniy', 'Nikolaevich', 'Olegov'),
                    '+752258741',
                    new Address('Russia', 'Magnitogorsk', 'Taynaya', '33', '22')
                ),
                new Recipient(
                    new FullName('Gaius', 'Iulius', 'Caesar'),
                    '+7777777',
                    new Address('USA', 'New-York', 'Park', 'Aveunue', '2')
                ),
                new Dimensions(8, 4, 3, 5),
                8
            ),
        ];
        $results[0]->setId('31');

        $this->parcelRepository->expects($this->once())->method('findByRecipientName')->with($q)->willReturn($results);
        $parcels = $this->parcelService->search($searchType, $q);

        $this->assertCount(1, $parcels);
    }

    public function testDeleteParcelNotFound()
    {
        $id = '123';

        $this->parcelRepository->expects($this->once())->method('findOneBy')->with(['id' => $id])->willReturn(null);

        $result = $this->parcelService->deleteParcel($id);

        $this->assertEquals('Посылка не нашлась', $result);
    }

    public function testDeleteParcel()
    {
        $id = '123';
        $parcel = new Parcel(
            new Sender(
                new FullName('Ilya', 'Petrovich', 'Petrov'),
                    '+583358741',
                new Address('Russia', 'Grozny', 'Kadyrova', '55', '55')
            ),
            new Recipient(
                new FullName('Nikolay', 'Nikolayevich', 'Nikolaev'),
                    '+6666666',
                new Address('Russia', 'Irkutsk', 'Lenina', '1', '1')
            ),
            new Dimensions(5, 5, 5, 5),
            5
        );
        $parcel->setId($id);

        $this->parcelRepository->expects($this->once())->method('findOneBy')->with(['id' => $id])->willReturn($parcel);

        $this->entityManager->expects($this->once())->method('remove')->with($parcel);
        $this->entityManager->expects($this->once())->method('flush');

        $result = $this->parcelService->deleteParcel($id);

        $this->assertEquals("Посылка №$id удалена", $result);
    }
}
