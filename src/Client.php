<?php

namespace App;

use App\Services\TokenService;
use App\DTO\TokenParams;
use App\DTO\CallTokenParams;
use InvalidArgumentException;

class Client
{
    private TokenService $tokenService;

    public function __construct(string $apiSecret)
    {
        $this->tokenService = new TokenService($apiSecret);
    }

    /**
     * Creates a user token with the given parameters
     * 
     * @param TokenParams $params Token parameters
     * @return string The generated JWT token
     * @throws InvalidArgumentException When parameters are invalid
     */
    public function createToken(TokenParams $params): string
    {
        return $this->tokenService->createToken($params);
    }

    /**
     * Creates a call token with the given parameters
     * 
     * @param CallTokenParams $params Call token parameters
     * @return string The generated JWT token
     * @throws InvalidArgumentException When parameters are invalid
     */
    public function createCallToken(CallTokenParams $params): string
    {
        return $this->tokenService->createCallToken($params);
    }
} 