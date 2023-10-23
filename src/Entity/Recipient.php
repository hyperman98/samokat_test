<?php

namespace App\Entity;

use App\Arrayable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Recipient implements Arrayable
{
    /**
     * @ORM\Embedded(class=FullName::class)
     */
    private FullName $fullName;

    /**
     * @ORM\Column(type="string")
     */
    private string $phone;

    /**
     * @ORM\Embedded(class=Address::class)
     */
    private Address $address;

    public function __construct(FullName $fullName, string $phone, Address $address)
    {
        $this->fullName = $fullName;
        $this->phone = $phone;
        $this->address = $address;
    }

    public function getFullName(): FullName
    {
        return $this->fullName;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function toArray(): array
    {
        return [
            'fullName' => $this->fullName->toArray(),
            'phone' => $this->phone,
            'address' => $this->address->toArray(),
        ];
    }
}
