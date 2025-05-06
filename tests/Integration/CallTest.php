<?php

namespace Tests\Integration;

use App\Call;
use App\Client;
use App\DTO\BackstageSettingsRequest;
use App\DTO\CallRequest;
use App\DTO\CallSettingsRequest;
use App\DTO\GetOrCreateCallRequest;
use App\DTO\MemberRequest;
use App\DTO\UserRequest;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CallTest extends TestCase
{
    private Client $client;
    private string $callType = 'livestream';
    private string $callId;
    private array $testUsers = [];

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

        // Generate a unique call ID for tests
        $this->callId = Uuid::uuid4()->toString();

        // Create test users
        $this->createTestUsers();
    }

    private function createTestUsers(): void
    {
        $userIds = ['adam', 'jane', 'tamara'];
        $users = [];

        foreach ($userIds as $userId) {
            $users[] = new UserRequest(
                id: $userId,
                role: 'user',
                name: ucfirst($userId),
                image: "https://example.com/{$userId}.jpg"
            );
        }

        $response = $this->client->upsertUsers($users);
        $this->testUsers = array_keys($response['users']);
    }

    private function deleteTestUsers(): void
    {
        if (!empty($this->testUsers)) {
            $this->client->deleteUsers($this->testUsers, [
                'user' => 'hard',
                'calls' => 'hard'
            ]);
        }
    }

    public function testGetOrCreateCallMinimal(): void
    {
        // Use the first user in the list as creator
        $creatorId = $this->testUsers[0];

        $call = $this->client->call($this->callType, $this->callId);
        $response = $call->getOrCreateCall(new GetOrCreateCallRequest(
            data: new CallRequest(
                createdById: $creatorId
            )
        ));

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('call', $response);
        $this->assertArrayHasKey('created_by', $response['call']);
        $this->assertEquals($creatorId, $response['call']['created_by']['id']);
    }

    public function testGetOrCreateCallWithSettingsOverride(): void
    {
        // Use the first user as creator
        $creatorId = $this->testUsers[0];
        
        // Create a call with all possible fields
        $members = [
            new MemberRequest(
                userId: $creatorId,
                role: 'admin'
            )
        ];

        $callRequest = new CallRequest(
            createdById: $creatorId,
            startsAt: (new \DateTime('+1 hour'))->format(\DateTime::ATOM), // ISO 8601 date string
            members: $members,
            settingsOverride: new CallSettingsRequest(
                backstage: new BackstageSettingsRequest(
                    enabled: true,
                    joinAheadTimeSeconds: 5*60
                )
            ),
            custom: ['topic' => 'Integration Test']
        );

        $request = new GetOrCreateCallRequest(
            data: $callRequest
        );

        $call = $this->client->call($this->callType, $this->callId);
        $response = $call->getOrCreateCall($request);

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('call', $response);
        
        $callData = $response['call'];
        $this->assertArrayHasKey('cid', $callData);
        $this->assertEquals("{$this->callType}:{$this->callId}", $callData['cid']);
        $this->assertEquals($creatorId, $callData['created_by']['id']);
        $this->assertEquals(5*60, $callData['settings']['backstage']['join_ahead_time_seconds']);
        $this->assertArrayHasKey('custom', $callData);
        $this->assertEquals('Integration Test', $callData['custom']['topic']);
    }

    public function testGetOrCreateCallWithMultipleMembers(): void
    {
        // Create a call with multiple members and notify flag
        $members = [
            new MemberRequest(userId: $this->testUsers[0], role: 'admin'),
            new MemberRequest(userId: $this->testUsers[1]),
            new MemberRequest(userId: $this->testUsers[2])
        ];

        $callRequest = new CallRequest(
            createdById: $this->testUsers[0],
            members: $members
        );

        $request = new GetOrCreateCallRequest(
            notify: true,
            data: $callRequest
        );

        $call = $this->client->call($this->callType, $this->callId);
        $response = $call->getOrCreateCall($request);

        // Assert the response structure
        $this->assertIsArray($response);
        $this->assertArrayHasKey('call', $response);
        $this->assertArrayHasKey('members', $response);
        
        // Count members (may include created_by already)
        $memberIds = array_map(
            fn($member) => $member['user_id'] ?? $member['user']['id'],
            $response['members']
        );
        
        // Ensure all our members are included
        $this->assertTrue(in_array($this->testUsers[0], $memberIds));
        $this->assertTrue(in_array($this->testUsers[1], $memberIds));
        $this->assertTrue(in_array($this->testUsers[2], $memberIds));
    }
} 