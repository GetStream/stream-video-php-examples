<?php

namespace App\DTO;

/**
 * Noise cancellation settings request DTO
 */
class NoiseCancellationSettingsRequest
{
    public function __construct(
        /** @var string Mode ('available', 'disabled', or 'auto-on') */
        private string $mode = 'available'
    ) {}

    public function getMode(): string
    {
        return $this->mode;
    }

    public function toArray(): array
    {
        return [
            'mode' => $this->mode
        ];
    }
} 