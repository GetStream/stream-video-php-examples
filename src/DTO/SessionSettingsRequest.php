<?php

namespace App\DTO;

/**
 * Session settings request DTO
 */
class SessionSettingsRequest
{
    public function __construct(
        /** @var int The inactivity timeout in seconds */
        private int $inactivityTimeoutSeconds
    ) {}

    public function getInactivityTimeoutSeconds(): int
    {
        return $this->inactivityTimeoutSeconds;
    }

    public function toArray(): array
    {
        return [
            'inactivity_timeout_seconds' => $this->inactivityTimeoutSeconds
        ];
    }
} 