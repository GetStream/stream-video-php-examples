<?php

namespace Tests\Integration;

use App\Client;
use App\DTO\UserRequest;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use Ramsey\Uuid\Uuid;

class ClientTest extends TestCase
{
    private Client $client;
    private string $userId1;
    private string $userId2;

    protected function setUp(): void
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        // Initialize client with credentials from .env
        $this->client = new Client(
            $_ENV['STREAM_API_KEY'],
            $_ENV['STREAM_API_SECRET']
        );

        // Generate unique UUIDs for test users
        $this->userId1 = Uuid::uuid4()->toString();
        $this->userId2 = Uuid::uuid4()->toString();
    }

    public function testUpsertUsers(): void
    {
        // Create test user data
        $users = [
            new UserRequest(
                id: $this->userId1,
                role: 'admin',
                name: 'Test User 1',
                image: 'https://example.com/avatar1.jpg'
            ),
            new UserRequest(
                id: $this->userId2,
                role: 'user',
                name: 'Test User 2',
                image: 'https://example.com/avatar2.jpg',
                custom: ['nickname' => 'User2']
            )
        ];

        // Perform the upsert
        $response = $this->client->upsertUsers($users);

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('users', $response);
        $this->assertCount(2, $response['users']);

        // Assert the returned users match what we sent
        foreach ($response['users'] as $user) {
            $this->assertArrayHasKey('id', $user);
            $this->assertArrayHasKey('role', $user);
            $this->assertArrayHasKey('name', $user);
            $this->assertArrayHasKey('image', $user);
            
            // Find the corresponding input user
            $inputUser = array_filter($users, fn($u) => $u->getId() === $user['id']);
            $inputUser = reset($inputUser);
            
            $this->assertNotFalse($inputUser);
            $this->assertEquals($inputUser->getRole(), $user['role']);
            $this->assertEquals($inputUser->getName(), $user['name']);
            $this->assertEquals($inputUser->getImage(), $user['image']);
            
            // Assert nickname for User2
            if ($user['id'] === $this->userId2) {
                $this->assertArrayHasKey('custom', $user);
                $this->assertArrayHasKey('nickname', $user['custom']);
                $this->assertEquals('User2', $user['custom']['nickname']);
            }
        }
    }

    public function testDeleteUserWithoutOptions(): void
    {
        // Delete the first user without any options
        $response = $this->client->deleteUsers([$this->userId1]);

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('task_id', $response);
        $this->assertNotEmpty($response['task_id']);
    }

    public function testDeleteUserWithHardOptions(): void
    {
        // Delete the second user with hard deletion options
        $response = $this->client->deleteUsers([$this->userId2], [
            'user' => 'hard',
            'calls' => 'hard'
        ]);

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('task_id', $response);
        $this->assertNotEmpty($response['task_id']);
    }
} 