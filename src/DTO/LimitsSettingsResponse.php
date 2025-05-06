<?php

namespace App\DTO;

/**
 * Limits settings response DTO
 */
class LimitsSettingsResponse
{
    public function __construct(
        /** @var int|null Maximum duration in seconds */
        private ?int $maxDurationSeconds = null,
        
        /** @var int|null Maximum number of participants */
        private ?int $maxParticipants = null
    ) {}

    public function getMaxDurationSeconds(): ?int
    {
        return $this->maxDurationSeconds;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->maxDurationSeconds !== null) {
            $data['max_duration_seconds'] = $this->maxDurationSeconds;
        }
        
        if ($this->maxParticipants !== null) {
            $data['max_participants'] = $this->maxParticipants;
        }
        
        return $data;
    }
} 