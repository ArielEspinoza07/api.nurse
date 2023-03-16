<?php

namespace Tests\Functional\src\Auth\Controller;

use Tests\Functional\src\Auth\AuthControllerTestBase;

class AuthenticateUserControllerTest extends AuthControllerTestBase
{

    protected string $endpoint = 'api:v1:auth:login';

    public function test_authenticate_user(): void
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => 'Api.nurse!1',
        ];

        $this->registerUser($payload);

        $loggedIn = $this->postJson(route($this->endpoint), $payload);

        $loggedIn->assertOk();
        $loggedIn->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $loggedIn->decodeResponseJson()['success']);
        $this->assertEquals('Logged in.', $loggedIn->decodeResponseJson()['message']);

        $this->assertArrayHasKey('token', $loggedIn->decodeResponseJson()['data']);
        $this->assertNotNull($loggedIn->decodeResponseJson()['data']['token']);
        $this->assertIsString($loggedIn->decodeResponseJson()['data']['token']);
        $this->assertEquals(42, strlen($loggedIn->decodeResponseJson()['data']['token']));
    }

    public function test_authenticate_with_non_existing_user(): void
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => 'Password!1',
        ];

        $loggedIn = $this->postJson(route($this->endpoint), $payload);

        $loggedIn->assertNotFound();
        $loggedIn->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $loggedIn->decodeResponseJson()['success']);

        $this->assertEquals(
            'Authentication failed: User was not found matching the entered credentials',
            $loggedIn->decodeResponseJson()['message']
        );

        $this->assertNull($loggedIn->decodeResponseJson()['data']);
    }

    public function test_authenticate_user_with_wrong_password(): void
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => 'Api.nurse!1',
        ];

        $this->registerUser($payload);

        $loggedIn = $this->postJson(route($this->endpoint), [
            'email' => $payload['email'],
            'password' => 'Api.nurse!12',
        ]);

        $loggedIn->assertUnauthorized();
        $loggedIn->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $loggedIn->decodeResponseJson()['success']);

        $this->assertEquals(
            sprintf('Authentication failed: The credentials for [%s] are invalid', $payload['email']),
            $loggedIn->decodeResponseJson()['message']
        );

        $this->assertNull($loggedIn->decodeResponseJson()['data']);
    }
}
