# Stream Video PHP Example

🏗️ IN PROGRESS

Example PHP code snippets for Stream Video API integration

## Requirements

- PHP: ^8.1

## Set up

Install dependencies:
```bash
composer install
```

## Token creation

Stream API documentation for tokens: https://getstream.io/video/docs/api/authentication/#user-tokens

### Provide user id

```php
use App\Client;
use App\DTO\TokenParams;

$client = new Client('your-api-secret');

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