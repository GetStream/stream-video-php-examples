<?php

namespace App;

use App\DTO\GetOrCreateCallRequest;
use App\Services\HttpService;
use GuzzleHttp\Exception\GuzzleException;

class Call
{
    private string $type;
    private string $id;
    private Client $client;

    public function __construct(string $type, string $id, Client $client)
    {
        $this->type = $type;
        $this->id = $id;
        $this->client = $client;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Get or create a call
     *
     * @param GetOrCreateCallRequest $request The request parameters for creating or retrieving a call
     * @return array Response containing call details
     * @throws GuzzleException When the HTTP request fails
     */
    public function getOrCreateCall(GetOrCreateCallRequest $request): array
    {
        $endpoint = sprintf('api/v2/video/call/%s/%s', $this->type, $this->id);
        
        return $this->client->httpService->post($endpoint, $request->toArray());
    }
} 