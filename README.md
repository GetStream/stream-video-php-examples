# Stream Video PHP Example

🏗️ IN PROGRESS

Example PHP code snippets for Stream Video API integration

## Requirements

- PHP: ^8.1

## Install dependencies

Install dependencies:
```bash
composer install
```

## Run the project

Create a `.env` file in the repository root, with this content:

```
STREAM_API_KEY=<Your API key>
STREAM_API_SECRET=<Your API secret>
```

### Unit Tests

```bash
composer test
```

### Integration Tests

```bash
vendor/bin/phpunit tests/Integration
```

### Main file

```bash
php src/main.php
```

## Create client

```php
use App\Client;

$apiKey = $_ENV['STREAM_API_KEY'];
$apiSecret = $_ENV['STREAM_API_SECRET'];
    
$client = new Client($apiKey, $apiSecret);
```

## Create or update users

API docs: https://getstream.io/video/docs/api/authentication/#creating-users

```php
$inputUser = new UserRequest(
    id: 'sara',
    role: 'user',
    name: 'Sara',
    image: 'https://example.com/avatar.jpg',
    custom: ['nickname' => 'Sara']
);

$response = $client->upsertUsers([$inputUser]);
```

## Token creation

Stream API documentation for tokens: https://getstream.io/video/docs/api/authentication/#user-tokens

### Provide user id

```php
use App\DTO\TokenParams;

// Create a basic token with just a user ID
$token = $client->createToken(new TokenParams(
    userId: 'user-123'
));
```

### Optionally provide validity in seconds

```php
// Create a token that expires in 2 hours (7200 seconds) - default validity is 1 hour
$token = $client->createToken(new TokenParams(
    userId: 'user-123',
    validityInSeconds: 7200
));
```

### Create call token

Allows access for specific calls only

```php
use App\DTO\CallTokenParams;

// Create a token for specific calls
$token = $client->createCallToken(new CallTokenParams(
    userId: 'user-123',
    callCids: ['livestream:123', 'livestream:456']
));
```

### Optionally provide a role for call tokens

```php
// Create a call token with a specific role
$token = $client->createCallToken(new CallTokenParams(
    userId: 'user-123',
    callCids: ['livestream:789'],
    role: 'admin'
));
```

## Create calls

API docs: https://getstream.io/video/docs/api/calls/#creating-calls

```php
// With only createdBy provided
$call = $this->client->call($this->callType, $this->callId);
$response = $call->getOrCreateCall(new GetOrCreateCallRequest(
    data: new CallRequest(
        createdById: '<user id>'
    )
));

$call = $client->call('livestream', Uuid::uuid4()->toString());
$callResponse = $call->getOrCreateCall(new GetOrCreateCallRequest(
    // Will send call.notification to members
    notify: true,
    data: new CallRequest(
        members: [new MemberRequest(userId: $user1['id']), new MemberRequest(userId: $user2['id'])],
        createdById: $user1['id'],
    ),
));

// Override call settings as well
$callRequest = new CallRequest(
    createdById: '<user id>',
    startsAt: (new \DateTime('+1 hour'))->format(\DateTime::ATOM), // ISO 8601 date string
    members: $members,
    settingsOverride: new CallSettingsRequest(
        backstage: new BackstageSettingsRequest(
            enabled: true,
            joinAheadTimeSeconds: 5*60
        )
    ),
    // Additionally you can provide custom data as well
    custom: ['topic' => 'Integration Test']
);
```

## Delete users

API docs: https://getstream.io/video/docs/api/gdpr/users/#users-deletion

```php
$response = $client->deleteUsers([$user['id']], [
    'user' => 'hard',
    'calls' => 'hard'
]);
```

## Useful resources

- API docs: https://getstream.io/video/docs/api/
- API spec file: https://getstream.github.io/protocol/?urls.primaryName=Video%20v2