<?php

namespace App\DTO;

class CallTokenParams extends TokenParams
{
    /** @var string[] */
    private array $callCids;
    private ?string $role;

    public function __construct(
        string $userId,
        array $callCids,
        ?string $role = null,
        ?int $validityInSeconds = null,
        ?int $exp = null,
        ?int $iat = null,
        array $additionalClaims = []
    ) {
        parent::__construct($userId, $validityInSeconds, $exp, $iat, $additionalClaims);
        $this->callCids = $callCids;
        $this->role = $role;
    }

    /**
     * @return string[]
     */
    public function getCallCids(): array
    {
        return $this->callCids;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Creates a CallTokenParams instance from an array
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['call_cids'],
            $data['role'] ?? null,
            $data['validity_in_seconds'] ?? null,
            $data['exp'] ?? null,
            $data['iat'] ?? null,
            array_diff_key($data, array_flip(['user_id', 'call_cids', 'role', 'validity_in_seconds', 'exp', 'iat']))
        );
    }

    /**
     * Converts the object to an array suitable for JWT claims
     */
    public function toArray(): array
    {
        $claims = parent::toArray();
        
        return array_merge($claims, [
            'call_cids' => $this->callCids,
            'role' => $this->role,
        ]);
    }
} 