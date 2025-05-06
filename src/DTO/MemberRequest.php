<?php

namespace App\DTO;

/**
 * Member request DTO
 */
class MemberRequest
{
    public function __construct(
        /** @var string User ID */
        private string $userId,
        /** @var string|null Role of the member */
        private ?string $role = null,
        /** @var array<string, mixed>|null Custom data for the member */
        private ?array $custom = null
    ) {}

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getCustom(): ?array
    {
        return $this->custom;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'user_id' => $this->userId,
        ];

        if ($this->role !== null) {
            $data['role'] = $this->role;
        }

        if ($this->custom !== null) {
            $data['custom'] = $this->custom;
        }

        return $data;
    }
} 