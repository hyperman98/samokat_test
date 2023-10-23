<?php

declare(strict_types=1);

namespace App\Dto;

final class Recipient
{
    public function __construct(
        public readonly FullName $fullName,
        public readonly string $phone,
    ) {
    }
}
