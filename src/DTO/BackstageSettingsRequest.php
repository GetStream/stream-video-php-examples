<?php

namespace App\DTO;

/**
 * Backstage settings request DTO
 */
class BackstageSettingsRequest
{
    public function __construct(
        /** @var bool|null Whether backstage is enabled */
        private ?bool $enabled = null,
        
        /** @var int|null Time in seconds that participants can join ahead of the call */
        private ?int $joinAheadTimeSeconds = null
    ) {}

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function getJoinAheadTimeSeconds(): ?int
    {
        return $this->joinAheadTimeSeconds;
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }
        
        if ($this->joinAheadTimeSeconds !== null) {
            $data['join_ahead_time_seconds'] = $this->joinAheadTimeSeconds;
        }
        
        return $data;
    }
} 