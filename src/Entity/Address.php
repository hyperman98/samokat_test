<?php

namespace App\Entity;

use App\Arrayable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Address implements Arrayable
{
    /**
     * @ORM\Column(type="string")
     */
    private string $country;

    /**
     * @ORM\Column(type="string")
     */
    private string $city;

    /**
     * @ORM\Column(type="string")
     */
    private string $street;

    /**
     * @ORM\Column(type="string")
     */
    private string $house;

    /**
     * @ORM\Column(type="string")
     */
    private string $apartment;

    public function __construct(string $country, string $city, string $street, string $house, string $apartment)
    {
        $this->country = $country;
        $this->city = $city;
        $this->street = $street;
        $this->house = $house;
        $this->apartment = $apartment;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouse(): string
    {
        return $this->house;
    }

    public function getApartment(): string
    {
        return $this->apartment;
    }

    public function toArray(): array
    {
        return [
            'country' => $this->country,
            'city' => $this->city,
            'street' => $this->street,
            'house' => $this->house,
            'apartment' => $this->apartment,
        ];
    }
}
