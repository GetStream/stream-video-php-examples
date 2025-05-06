<?php

namespace App\DTO;

class ReadReceiptsResponse
{
    public function __construct(
        /** @var bool|null Whether read receipts are enabled */
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