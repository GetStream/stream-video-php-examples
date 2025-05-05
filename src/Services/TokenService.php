<?php

namespace App\Services;

use App\DTO\TokenParams;
use App\DTO\CallTokenParams;
use Firebase\JWT\JWT;
use InvalidArgumentException;

class TokenService
{
    private string $apiSecret;

    public function __construct(string $apiSecret)
    {
        if (empty($apiSecret)) {
            throw new InvalidArgumentException('API secret cannot be empty');
        }
        $this->apiSecret = $apiSecret;
    }

    /**
     * Creates a signed JWT token with the given parameters
     * 
     * @param TokenParams $params Token parameters
     * @return string The generated JWT token
     * @throws InvalidArgumentException When parameters are invalid
     */
    public function createToken(TokenParams $params): string
    {
        $now = time();
        $iat = $params->getIat() ?? $now - 1;
        $claims = [
            'iat' => $iat,
        ];

        // Handle expiration time
        if ($params->getValidityInSeconds() !== null) {
            $claims['exp'] = $iat + $params->getValidityInSeconds();
        } elseif ($params->getExp() !== null) {
            $claims['exp'] = $params->getExp();
        } else {
            $claims['exp'] = $iat + 3600; // Default 1 hour expiration
        }

        $payload = array_merge($claims, $params->toArray());

        return JWT::encode($payload, $this->apiSecret, 'HS256');
    }

    /**
     * Creates a signed JWT token specifically for call authentication
     * 
     * @param CallTokenParams $params Call token parameters
     * @return string The generated JWT token
     * @throws InvalidArgumentException When parameters are invalid
     */
    public function createCallToken(CallTokenParams $params): string
    {
        return $this->createToken($params);
    }
} 