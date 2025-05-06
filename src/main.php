<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Client;
use App\DTO\TokenParams;
use App\DTO\UserRequest;
use App\DTO\GetOrCreateCallRequest;
use App\DTO\CallRequest;
use App\DTO\MemberRequest;
use App\DTO\GoLiveRequest;
use App\DTO\StopLiveRequest;
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

    $call = $client->call('livestream', 'testing-livestream-with-php');
    $callResponse = $call->getOrCreateCall(new GetOrCreateCallRequest(
        // Will send call.notification to members
        notify: true,
        data: new CallRequest(
            members: [new MemberRequest(userId: $user1['id']), new MemberRequest(userId: $user2['id'])],
            createdById: $user1['id'],
        ),
    ));
    echo "Call created: " . $callResponse['call']['id'] . "\n";
    
    // Go live only works when there is an active session for the call
    // // Start broadcasting the call
    // $call->goLive(new GoLiveRequest());
    // echo "Call is now live with default settings\n";
    
    // // Start broadcasting with additional options
    // $call->goLive(new GoLiveRequest(
    //     // Optionally start displaying closed captions for call participants
    //     start_closed_caption: true,
    //     // Optionally start HLS broadcast
    //     start_hls: true,
    //     // Optionally start recording the call
    //     start_recording: true,
    //     // Optionally start saving the call transcription to a file
    //     start_transcription: true,
    // ));
    // echo "Call is now live with additional features enabled\n";

    // // Stop broadcasting the call
    // $call->stopLive(new StopLiveRequest());
    // echo "Call is no longer live with default settings\n";
    
    // // Stop broadcasting with additional options
    // $call->stopLive(new StopLiveRequest(
    //     // Optionally prevent stopping HLS broadcast
    //     continue_hls: true,
    //     // Optionally prevent stopping recording
    //     continue_recording: true,
    //     // Optionally prevent stopping closed captions
    //     continue_closed_caption: true,
    //     // Optionally prevent stopping call transcription
    //     continue_transcription: true,
    // ));
    // echo "Call live features selectively stopped\n";
}

// Run the main function
main(); 