<?php

namespace App\DTO;

class TypingIndicatorsResponse
{
    public function __construct(
        /** @var bool|null Whether typing indicators are enabled */
        private ?bool $enabled = null
    ) {}

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function toArray(): array
    {
        $data = [];

        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }

        return $data;
    }
} 