<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class HttpService
{
    private GuzzleClient $client;
    private string $baseUrl;
    private string $apiKey;

    public function __construct(
        string $apiKey = '',
        string $token = '',
        string $baseUrl = 'https://video.stream-io-api.com',
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'http_errors' => true,
            'headers' => [
                'stream-auth-type' => 'jwt',
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept-Encoding' => 'gzip',
            ],
            'debug' => false
        ]);
    }

    /**
     * Generate headers for the request including a unique request ID
     *
     * @return array
     */
    private function getRequestHeaders(): array
    {
        return [
            'x-client-request-id' => Uuid::uuid4()->toString(),
        ];
    }

    /**
     * Get common query parameters
     *
     * @param array $query Additional query parameters
     * @return array
     */
    private function getQueryParams(array $query = []): array
    {
        return array_merge(['api_key' => $this->apiKey], $query);
    }

    /**
     * Handle error responses
     *
     * @param GuzzleException $e
     * @throws GuzzleException
     */
    private function handleError(GuzzleException $e): void
    {
        if ($e instanceof ClientException) {
            $response = $e->getResponse();
            $body = $response->getBody()->getContents();
            $statusCode = $response->getStatusCode();
            
            echo "\nRequest failed with status code: " . $statusCode . "\n";
            echo "Response body: " . $body . "\n";
            echo "Request URL: " . $e->getRequest()->getUri() . "\n";
            echo "Request headers: \n";
            foreach ($e->getRequest()->getHeaders() as $name => $values) {
                echo $name . ': ' . implode(', ', $values) . "\n";
            }
        }
        
        throw $e;
    }

    /**
     * Send a GET request
     *
     * @param string $endpoint
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function get(string $endpoint, array $query = []): array
    {
        try {
            $response = $this->client->get($endpoint, [
                'query' => $this->getQueryParams($query),
                'headers' => $this->getRequestHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Send a POST request
     *
     * @param string $endpoint
     * @param array|null $data
     * @return array
     * @throws GuzzleException
     */
    public function post(string $endpoint, ?array $data = []): array
    {
        try {
            echo "\nSending POST request to: " . $this->baseUrl . '/' . $endpoint . "\n";
            echo "Request body: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
            
            $options = [
                'query' => $this->getQueryParams(),
                'headers' => $this->getRequestHeaders(),
            ];
            
            // Only include json data if it's not null
            if ($data !== null) {
                $options['json'] = $data;
            }
            
            $response = $this->client->post($endpoint, $options);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Send a PUT request
     *
     * @param string $endpoint
     * @param array|null $data
     * @return array
     * @throws GuzzleException
     */
    public function put(string $endpoint, ?array $data = []): array
    {
        try {
            $options = [
                'query' => $this->getQueryParams(),
                'headers' => $this->getRequestHeaders(),
            ];
            
            // Only include json data if it's not null
            if ($data !== null) {
                $options['json'] = $data;
            }
            
            $response = $this->client->put($endpoint, $options);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->handleError($e);
        }
    }

    /**
     * Send a DELETE request
     *
     * @param string $endpoint
     * @return array
     * @throws GuzzleException
     */
    public function delete(string $endpoint): array
    {
        try {
            $response = $this->client->delete($endpoint, [
                'query' => $this->getQueryParams(),
                'headers' => $this->getRequestHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            $this->handleError($e);
        }
    }
} 