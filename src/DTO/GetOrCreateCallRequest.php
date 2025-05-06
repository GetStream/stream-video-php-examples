<?php

namespace App\DTO;

/**
 * Get or create call request DTO
 */
class GetOrCreateCallRequest
{
    public function __construct(
        /** @var int|null Maximum number of members for the call */
        private ?int $membersLimit = null,
        /** @var bool|null Whether to notify members about the call */
        private ?bool $notify = null,
        /** @var bool|null Whether to ring the call */
        private ?bool $ring = null,
        /** @var bool|null Whether video is enabled */
        private ?bool $video = null,
        /** @var CallRequest|null Call request data */
        private ?CallRequest $data = null
    ) {}

    /**
     * @return int|null
     */
    public function getMembersLimit(): ?int
    {
        return $this->membersLimit;
    }

    /**
     * @return bool|null
     */
    public function getNotify(): ?bool
    {
        return $this->notify;
    }

    /**
     * @return bool|null
     */
    public function getRing(): ?bool
    {
        return $this->ring;
    }

    /**
     * @return bool|null
     */
    public function getVideo(): ?bool
    {
        return $this->video;
    }

    /**
     * @return CallRequest|null
     */
    public function getData(): ?CallRequest
    {
        return $this->data;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->membersLimit !== null) {
            $data['members_limit'] = $this->membersLimit;
        }

        if ($this->notify !== null) {
            $data['notify'] = $this->notify;
        }

        if ($this->ring !== null) {
            $data['ring'] = $this->ring;
        }

        if ($this->video !== null) {
            $data['video'] = $this->video;
        }

        if ($this->data !== null) {
            $data['data'] = $this->data->toArray();
        }

        return $data;
    }
} 