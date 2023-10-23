<?php

namespace App\Entity;

use App\Arrayable;
use App\Repository\ParcelRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParcelRepository::class)
 */
class Parcel implements Arrayable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue()
     * @ORM\Column(type="string")
     */
    private string $id;

    /**
     * @ORM\Embedded(class=Sender::class)
     */
    private Sender $sender;

    /**
     * @ORM\Embedded(class=Recipient::class)
     */
    private Recipient $recipient;

    /**
     * @ORM\Embedded(class=Dimensions::class)
     */
    private Dimensions $dimensions;

    /**
     * @ORM\Column(type="integer")
     */
    private int $estimatedCost;

    public function __construct(Sender $sender, Recipient $recipient, Dimensions $dimensions, int $estimatedCost)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->dimensions = $dimensions;
        $this->estimatedCost = $estimatedCost;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSender(): Sender
    {
        return $this->sender;
    }

    public function getRecipient(): Recipient
    {
        return $this->recipient;
    }

    public function getDimensions(): Dimensions
    {
        return $this->dimensions;
    }

    public function getEstimatedCost(): int
    {
        return $this->estimatedCost;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'sender' => $this->sender->toArray(),
            'receiver' => $this->recipient->toArray(),
            'dimensions' => $this->dimensions->toArray(),
            'estimatedCost' => $this->estimatedCost,
        ];
    }
}
