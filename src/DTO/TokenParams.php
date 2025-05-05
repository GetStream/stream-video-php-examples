<?php

namespace App\DTO;

class TokenParams
{
    private string $userId;
    private ?int $validityInSeconds;
    private ?int $exp;
    private ?int $iat;
    private array $additionalClaims;

    public function __construct(
        string $userId,
        ?int $validityInSeconds = null,
        ?int $exp = null,
        ?int $iat = null,
        array $additionalClaims = []
    ) {
        $this->userId = $userId;
        $this->validityInSeconds = $validityInSeconds;
        $this->exp = $exp;
        $this->iat = $iat;
        $this->additionalClaims = $additionalClaims;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getValidityInSeconds(): ?int
    {
        return $this->validityInSeconds;
    }

    public function getExp(): ?int
    {
        return $this->exp;
    }

    public function getIat(): ?int
    {
        return $this->iat;
    }

    public function getAdditionalClaims(): array
    {
        return $this->additionalClaims;
    }

    /**
     * Creates a TokenParams instance from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['validity_in_seconds'] ?? null,
            $data['exp'] ?? null,
            $data['iat'] ?? null,
            array_diff_key($data, array_flip(['user_id', 'validity_in_seconds', 'exp', 'iat']))
        );
    }

    /**
     * Converts the object to an array suitable for JWT claims
     */
    public function toArray(): array
    {
        $claims = [
            'user_id' => $this->userId,
        ];

        return array_merge($claims, $this->additionalClaims);
    }
} 