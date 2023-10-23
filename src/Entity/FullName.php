<?php

namespace App\Entity;

use App\Arrayable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class FullName implements Arrayable
{
    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private string $middleName;

    public function __construct(string $firstName, string $lastName, string $middleName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
        ];
    }
}
