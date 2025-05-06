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
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        $this->client = new Client(
            $_ENV['STREAM_API_KEY'],
            $_ENV['STREAM_API_SECRET']
        );

        $this->userId1 = Uuid::uuid4()->toString();
        $this->userId2 = Uuid::uuid4()->toString();
    }

    public function testUpsertUsers(): void
    {
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

        $response = $this->client->upsertUsers($users);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('users', $response);
        $this->assertCount(2, $response['users']);

        foreach ($response['users'] as $user) {
            $this->assertArrayHasKey('id', $user);
            $this->assertArrayHasKey('role', $user);
            $this->assertArrayHasKey('name', $user);
            $this->assertArrayHasKey('image', $user);
            
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
        $response = $this->client->deleteUsers([$this->userId1]);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('task_id', $response);
        $this->assertNotEmpty($response['task_id']);
    }

    public function testDeleteUserWithHardOptions(): void
    {
        $response = $this->client->deleteUsers([$this->userId2], [
            'user' => 'hard',
            'calls' => 'hard'
        ]);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('task_id', $response);
        $this->assertNotEmpty($response['task_id']);
    }
} 