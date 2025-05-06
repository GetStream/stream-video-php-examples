<?php

namespace App;

use App\Services\TokenService;
use App\Services\HttpService;
use App\DTO\TokenParams;
use App\DTO\CallTokenParams;
use App\DTO\UserRequest;
use InvalidArgumentException;

class Client
{
    private string $apiKey;
    private TokenService $tokenService;
    private HttpService $httpService;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->tokenService = new TokenService($apiSecret);
        $serverToken = $this->tokenService->createServerToken();
        $this->httpService = new HttpService(token: $serverToken, apiKey: $apiKey);
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

    /**
     * Upserts (creates or updates) users in the Stream Video API
     * 
     * @param UserRequest[] $users Array of user data to upsert
     * @return array Response from the API containing the upserted users
     * @throws \GuzzleHttp\Exception\GuzzleException When the API request fails
     */
    public function upsertUsers(array $users): array
    {
        $userRequest = array_reduce($users, function($acc, UserRequest $user) {
            $acc[$user->getId()] = $user->toArray();
            return $acc;
        }, []);
        
        return $this->httpService->post('api/v2/users', [
            'users' => $userRequest
        ]);
    }

    /**
     * Deletes multiple users with options for soft/hard deletion
     * 
     * @param array $userIds Array of user IDs to delete
     * @param array $options Deletion options:
     *                      - user: string (soft, pruning, hard)
     *                      - messages: string (soft, pruning, hard)
     *                      - conversations: string (soft, hard)
     *                      - calls: string (soft, hard)
     *                      - new_channel_owner_id: string
     *                      - new_call_owner_id: string
     * @return array Response containing task_id for tracking deletion progress
     * @throws \GuzzleHttp\Exception\GuzzleException When the API request fails
     */
    public function deleteUsers(array $userIds, array $options = []): array
    {
        $payload = ['user_ids' => $userIds];

        $possibleOptions = [
            'user',
            'messages',
            'conversations',
            'calls',
            'new_channel_owner_id',
            'new_call_owner_id'
        ];

        foreach ($possibleOptions as $option) {
            if (isset($options[$option])) {
                $payload[$option] = $options[$option];
            }
        }

        return $this->httpService->post('api/v2/users/delete', $payload);
    }
} 