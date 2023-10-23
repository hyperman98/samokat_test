<?php

declare(strict_types=1);

namespace App\Dto;

final class ParcelDto
{
    public function __construct(
        public readonly string $id,
        public readonly Sender $sender,
        public readonly Recipient $receiver,
        public readonly Dimensions $dimensions,
        public readonly int $estimatedCost
    ) {
    }
}
