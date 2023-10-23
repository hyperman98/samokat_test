<?php

declare(strict_types=1);

namespace App\Dto;

final class FullName
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $middleName,
    ) {
    }
}
