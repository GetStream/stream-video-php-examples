<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Client;
use App\DTO\TokenParams;
use App\DTO\UserRequest;
use App\DTO\GetOrCreateCallRequest;
use App\DTO\CallRequest;
use App\DTO\MemberRequest;
use Dotenv\Dotenv;
use Ramsey\Uuid\Uuid;

function main() {
    // Load environment variables from .env file
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // You can now access environment variables using $_ENV or getenv()
    $apiKey = $_ENV['STREAM_API_KEY'];
    $apiSecret = $_ENV['STREAM_API_SECRET'];
    
    $client = new Client($apiKey, $apiSecret);

    // Create new users
    $inputUser1 = new UserRequest(
        id: 'sara',
        role: 'user',
        name: 'Sara',
        image: 'https://example.com/avatar.jpg',
        custom: ['nickname' => 'Sara']
    );

    $inputUser2 = new UserRequest(
        id: 'adam',
        role: 'admin',
        name: 'Adam',
        image: 'https://example.com/avatar2.jpg'
    );

    $response = $client->upsertUsers([$inputUser1, $inputUser2]);
    $user1 = $response['users'][$inputUser1->getId()];
    $user2 = $response['users'][$inputUser2->getId()];
    echo "Created user: " . $user1['id'] . "\n";
    echo "Created user: " . $user2['id'] . "\n";

    // Create a token for the user
    $token = $client->createToken(new TokenParams(
        userId: $user1['id'],
    ));
    echo "Generated token: " . $token . "\n";

    $call = $client->call('livestream', Uuid::uuid4()->toString());
    $callResponse = $call->getOrCreateCall(new GetOrCreateCallRequest(
        // Will send call.notification to members
        notify: true,
        data: new CallRequest(
            members: [new MemberRequest(userId: $user1['id']), new MemberRequest(userId: $user2['id'])],
            createdById: $user1['id'],
        ),
    ));
    echo "Call created: " . $callResponse['call']['id'] . "\n";

    // Hard delete the users
    $response = $client->deleteUsers([$user1['id'], $user2['id']], [
        'user' => 'hard',
        'calls' => 'hard'
    ]);
    echo "Delete user task created with id: " . $response['task_id'] . "\n";
}

// Run the main function
main(); 