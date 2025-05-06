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
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        $this->client = new Client(
            $_ENV['STREAM_API_KEY'],
            $_ENV['STREAM_API_SECRET']
        );

        $this->callId = Uuid::uuid4()->toString();

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

    public function testGetOrCreateCallMinimal(): void
    {
        $creatorId = $this->testUsers[0];

        $call = $this->client->call($this->callType, $this->callId);
        $response = $call->getOrCreateCall(new GetOrCreateCallRequest(
            data: new CallRequest(
                createdById: $creatorId
            )
        ));

        $this->assertIsArray($response);
        $this->assertArrayHasKey('call', $response);
        $this->assertArrayHasKey('created_by', $response['call']);
        $this->assertEquals($creatorId, $response['call']['created_by']['id']);
    }

    public function testGetOrCreateCallWithSettingsOverride(): void
    {
        $creatorId = $this->testUsers[0];
        
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

        $this->assertIsArray($response);
        $this->assertArrayHasKey('call', $response);
        $this->assertArrayHasKey('members', $response);
        
        $memberIds = array_map(
            fn($member) => $member['user_id'] ?? $member['user']['id'],
            $response['members']
        );
        
        $this->assertTrue(in_array($this->testUsers[0], $memberIds));
        $this->assertTrue(in_array($this->testUsers[1], $memberIds));
        $this->assertTrue(in_array($this->testUsers[2], $memberIds));
    }
    
    public function testDeleteCall(): void
    {
        // First create a call
        $creatorId = $this->testUsers[0];
        $callId = Uuid::uuid4()->toString();
        
        $call = $this->client->call($this->callType, $callId);
        $createResponse = $call->getOrCreateCall(new GetOrCreateCallRequest(
            data: new CallRequest(
                createdById: $creatorId
            )
        ));
        
        $this->assertIsArray($createResponse);
        $this->assertArrayHasKey('call', $createResponse);
        
        $deleteResponse = $call->deleteCall();
        
        $this->assertIsArray($deleteResponse);
        $this->assertArrayHasKey('duration', $deleteResponse);
        
        $callIdForHardDelete = Uuid::uuid4()->toString();
        $callForHardDelete = $this->client->call($this->callType, $callIdForHardDelete);
        
        $createResponse = $callForHardDelete->getOrCreateCall(new GetOrCreateCallRequest(
            data: new CallRequest(
                createdById: $creatorId
            )
        ));
        
        $hardDeleteResponse = $callForHardDelete->deleteCall(true);
        
        $this->assertIsArray($hardDeleteResponse);
        $this->assertArrayHasKey('duration', $hardDeleteResponse);
    }
} 