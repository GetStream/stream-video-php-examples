<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Client;
use App\DTO\TokenParams;
use App\DTO\UserData;
use Dotenv\Dotenv;

function main() {
    // Load environment variables from .env file
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    
    // You can now access environment variables using $_ENV or getenv()
    $apiKey = $_ENV['STREAM_API_KEY'];
    $apiSecret = $_ENV['STREAM_API_SECRET'];
    
    $client = new Client($apiKey, $apiSecret);

    // Create a new user
    $inputUser = new UserData(
        id: 'sara',
        role: 'user',
        name: 'Sara',
        image: 'https://example.com/avatar.jpg',
        custom: ['nickname' => 'Sara']
    );
    $response = $client->upsertUsers([$inputUser]);
    $user = $response['users'][$inputUser->getId()];
    echo "Created user: " . $user['id'] . "\n";

    // Create a token for the user
    $token = $client->createToken(new TokenParams(
        userId: $user['id'],
    ));
    echo "Generated token: " . $token . "\n";

    // Hard delete the user
    $response = $client->deleteUsers([$user['id']], [
        'user' => 'hard',
        'calls' => 'hard'
    ]);
    echo "Delete user task created with id: " . $response['task_id'] . "\n";
}

// Run the main function
main(); 