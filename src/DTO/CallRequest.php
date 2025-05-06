<?php

namespace App\DTO;

/**
 * Call request DTO
 */
class CallRequest
{
    public function __construct(
        /** @var string|null ID of the user who created the call */
        private ?string $createdById = null,
        /** @var string|null Start time of the call as ISO data string*/
        private ?string $startsAt = null,
        /** @var string|null Team ID */
        private ?string $team = null,
        /** @var bool|null Whether video is enabled */
        private ?bool $video = null,
        /** @var MemberRequest[]|null Members of the call */
        private ?array $members = null,
        /** @var UserRequest|null User who created the call */
        private ?UserRequest $createdBy = null,
        /** @var array<string, mixed>|null Custom data for the call */
        private ?array $custom = null,
        /** @var CallSettingsRequest|null Settings override for the call */
        private ?CallSettingsRequest $settingsOverride = null
    ) {}

    /**
     * @return string|null
     */
    public function getCreatedById(): ?string
    {
        return $this->createdById;
    }

    /**
     * @return string|null
     */
    public function getStartsAt(): ?int
    {
        return $this->startsAt;
    }

    /**
     * @return string|null
     */
    public function getTeam(): ?string
    {
        return $this->team;
    }

    /**
     * @return bool|null
     */
    public function getVideo(): ?bool
    {
        return $this->video;
    }

    /**
     * @return MemberRequest[]|null
     */
    public function getMembers(): ?array
    {
        return $this->members;
    }

    /**
     * @return UserRequest|null
     */
    public function getCreatedBy(): ?UserRequest
    {
        return $this->createdBy;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCustom(): ?array
    {
        return $this->custom;
    }

    /**
     * @return CallSettingsRequest|null
     */
    public function getSettingsOverride(): ?CallSettingsRequest
    {
        return $this->settingsOverride;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->createdById !== null) {
            $data['created_by_id'] = $this->createdById;
        }

        if ($this->startsAt !== null) {
            $data['starts_at'] = $this->startsAt;
        }

        if ($this->team !== null) {
            $data['team'] = $this->team;
        }

        if ($this->video !== null) {
            $data['video'] = $this->video;
        }

        if ($this->members !== null) {
            $data['members'] = array_map(
                fn (MemberRequest $member) => $member->toArray(),
                $this->members
            );
        }

        if ($this->createdBy !== null) {
            $data['created_by'] = $this->createdBy->toArray();
        }

        if ($this->custom !== null) {
            $data['custom'] = $this->custom;
        }

        if ($this->settingsOverride !== null) {
            $data['settings_override'] = $this->settingsOverride->toArray();
        }

        return $data;
    }
} 