<?php

declare(strict_types=1);

namespace App\Dto;

final class Address
{
    public function __construct(
        public readonly string $country,
        public readonly string $city,
        public readonly string $street,
        public readonly string $house,
        public readonly string $apartment,
    ) {
    }
}
