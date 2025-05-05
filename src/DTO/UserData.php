<?php

namespace App\DTO;

class UserData
{
    public function __construct(
        private string $id,
        private string $role,
        private ?string $name = null,
        private ?string $image = null,
        private ?array $custom = null,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getCustom(): ?array
    {
        return $this->custom;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'role' => $this->role,
        ];

        if ($this->name !== null) {
            $data['name'] = $this->name;
        }

        if ($this->image !== null) {
            $data['image'] = $this->image;
        }

        if ($this->custom !== null) {
            $data['custom'] = $this->custom;
        }

        return $data;
    }
} 