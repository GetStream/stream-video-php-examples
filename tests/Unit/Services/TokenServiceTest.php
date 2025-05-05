<?php

namespace Tests\Unit\Services;

use App\DTO\TokenParams;
use App\Services\TokenService;
use App\DTO\CallTokenParams;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class TokenServiceTest extends TestCase
{
    private const TEST_SECRET = 'test-secret-key-12345';
    private TokenService $tokenService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenService = new TokenService(self::TEST_SECRET);
    }

    public function testCreateTokenWithRequiredParamsOnly(): void
    {
        $userId = 'test-user-123';
        $params = new TokenParams($userId);

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($userId, $decoded->user_id);
        $this->assertIsInt($decoded->iat);
        $this->assertIsInt($decoded->exp);
        $this->assertEquals($decoded->exp, $decoded->iat + 3600); // Default 1 hour expiration
    }

    public function testCreateTokenWithCustomValidity(): void
    {
        $validityInSeconds = 7200; // 2 hours
        $params = new TokenParams(
            userId: 'test-user',
            validityInSeconds: $validityInSeconds
        );

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($decoded->exp, $decoded->iat + $validityInSeconds);
    }

    public function testCreateTokenWithExplicitExpiration(): void
    {
        $now = time();
        $explicitExp = $now + 5400; // 1.5 hours from now
        $params = new TokenParams(
            userId: 'test-user',
            exp: $explicitExp
        );

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($explicitExp, $decoded->exp);
    }

    public function testCreateTokenWithAdditionalClaims(): void
    {
        $additionalClaims = [
            'role' => 'admin',
            'permissions' => ['read', 'write'],
            'email' => 'test@example.com'
        ];

        $params = new TokenParams(
            userId: 'test-user',
            additionalClaims: $additionalClaims
        );

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals('admin', $decoded->role);
        $this->assertEquals(['read', 'write'], $decoded->permissions);
        $this->assertEquals('test@example.com', $decoded->email);
    }

    public function testCreateTokenWithExplicitIat(): void
    {
        $explicitIat = time() - 60; // 1 minute ago
        $params = new TokenParams(
            userId: 'test-user',
            iat: $explicitIat
        );

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($explicitIat, $decoded->iat);
    }

    public function testTokenServiceConstructorWithEmptySecret(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('API secret cannot be empty');
        
        new TokenService('');
    }

    public function testValidityTakesPrecedenceOverExplicitExp(): void
    {
        $now = time();
        $validityInSeconds = 3600; // 1 hour
        $explicitExp = $now + 7200; // 2 hours

        $params = new TokenParams(
            userId: 'test-user',
            validityInSeconds: $validityInSeconds,
            exp: $explicitExp
        );

        $token = $this->tokenService->createToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        // Should use validityInSeconds instead of explicit exp
        $this->assertEquals($decoded->exp, $decoded->iat + $validityInSeconds);
    }

    public function testCreateCallTokenWithBasicParams(): void
    {
        $userId = 'test-user-123';
        $callCids = ['livestream:123', 'livestream:456'];
        $params = new CallTokenParams(
            userId: $userId,
            callCids: $callCids
        );

        $token = $this->tokenService->createCallToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($userId, $decoded->user_id);
        $this->assertEquals($callCids, $decoded->call_cids);
        $this->assertNull($decoded->role);
        $this->assertIsInt($decoded->iat);
        $this->assertIsInt($decoded->exp);
        $this->assertEquals($decoded->exp, $decoded->iat + 3600); // Default 1 hour expiration
    }

    public function testCreateCallTokenWithAllParams(): void
    {
        $userId = 'test-user-123';
        $callCids = ['livestream:789'];
        $role = 'admin';
        $validityInSeconds = 7200; // 2 hours
        $additionalClaims = ['custom_field' => 'value'];

        $params = new CallTokenParams(
            userId: $userId,
            callCids: $callCids,
            role: $role,
            validityInSeconds: $validityInSeconds,
            additionalClaims: $additionalClaims
        );

        $token = $this->tokenService->createCallToken($params);
        $decoded = JWT::decode($token, new Key(self::TEST_SECRET, 'HS256'));

        $this->assertEquals($userId, $decoded->user_id);
        $this->assertEquals($callCids, $decoded->call_cids);
        $this->assertEquals($role, $decoded->role);
        $this->assertEquals('value', $decoded->custom_field);
        $this->assertEquals($decoded->exp, $decoded->iat + $validityInSeconds);
    }
} 