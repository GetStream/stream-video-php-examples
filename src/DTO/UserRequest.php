<?php

namespace App\DTO;

class UserRequest
{
    public function __construct(
        /** @var string User ID */
        private string $id,
        /** @var string|null User profile image URL */
        private ?string $image = null,
        /** @var bool|null Whether the user is invisible */
        private ?bool $invisible = null,
        /** @var string|null User preferred language */
        private ?string $language = null,
        /** @var string|null User display name */
        private ?string $name = null,
        /** @var string|null User role */
        private ?string $role = null,
        /** @var string[]|null List of team IDs the user belongs to */
        private ?array $teams = null,
        /** @var array<string, mixed>|null Custom user data */
        private ?array $custom = null,
        /** @var PrivacySettingsResponse|null User privacy settings */
        private ?PrivacySettingsResponse $privacySettings = null,
        /** @var array<string, string>|null Mapping of team IDs to roles */
        private ?array $teamsRole = null,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getInvisible(): ?bool
    {
        return $this->invisible;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getTeams(): ?array
    {
        return $this->teams;
    }

    public function getCustom(): ?array
    {
        return $this->custom;
    }

    public function getPrivacySettings(): ?PrivacySettingsResponse
    {
        return $this->privacySettings;
    }

    public function getTeamsRole(): ?array
    {
        return $this->teamsRole;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
        ];

        if ($this->image !== null) {
            $data['image'] = $this->image;
        }

        if ($this->invisible !== null) {
            $data['invisible'] = $this->invisible;
        }

        if ($this->language !== null) {
            $data['language'] = $this->language;
        }

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->role !== null) {
            $data['role'] = $this->role;
        }

        if ($this->teams !== null) {
            $data['teams'] = $this->teams;
        }

        if ($this->custom !== null) {
            $data['custom'] = $this->custom;
        }

        if ($this->privacySettings !== null) {
            $data['privacy_settings'] = $this->privacySettings->toArray();
        }

        if ($this->teamsRole !== null) {
            $data['teams_role'] = $this->teamsRole;
        }

        return $data;
    }
} 