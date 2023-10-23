<?php

namespace App\Entity;

use App\Arrayable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class Dimensions implements Arrayable
{
    /**
     * @ORM\Column(type="integer")
     */
    private int $weight;

    /**
     * @ORM\Column(type="integer")
     */
    private int $length;

    /**
     * @ORM\Column(type="integer")
     */
    private int $height;

    /**
     * @ORM\Column(type="integer")
     */
    private int $width;

    public function __construct(int $weight, int $length, int $height, int $width)
    {
        $this->weight = $weight;
        $this->length = $length;
        $this->height = $height;
        $this->width = $width;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function toArray(): array
    {
        return [
        'weight' => $this->weight,
        'length' => $this->length,
        'height' => $this->height,
        'width' => $this->width,
        ];
    }
}
