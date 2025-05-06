<?php

namespace App;

use App\DTO\GetOrCreateCallRequest;
use App\DTO\GoLiveRequest;
use App\DTO\StopLiveRequest;
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
    
    /**
     * Make a call go live
     *
     * @param GoLiveRequest $request The request parameters for making the call go live
     * @return array Response containing the go live result
     * @throws GuzzleException When the HTTP request fails
     */
    public function goLive(GoLiveRequest $request): array
    {
        $endpoint = sprintf('api/v2/video/call/%s/%s/go_live', $this->type, $this->id);
        
        return $this->client->httpService->post($endpoint, $request->toArray());
    }

    /**
     * Stop a live call
     *
     * @param StopLiveRequest $request The request parameters for stopping the live call
     * @return array Response containing the stop live result
     * @throws GuzzleException When the HTTP request fails
     */
    public function stopLive(StopLiveRequest $request): array
    {
        $endpoint = sprintf('api/v2/video/call/%s/%s/stop_live', $this->type, $this->id);
        
        return $this->client->httpService->post($endpoint, $request->toArray());
    }

    /**
     * Delete a call
     *
     * @param bool $hard Whether to perform a hard delete (true) or soft delete (false)
     * @return array Response containing the delete call result
     * @throws GuzzleException When the HTTP request fails
     */
    public function deleteCall(bool $hard = false): array
    {
        $endpoint = sprintf('api/v2/video/call/%s/%s/delete', $this->type, $this->id);
        
        return $this->client->httpService->post($endpoint, ['hard' => $hard]);
    }
}