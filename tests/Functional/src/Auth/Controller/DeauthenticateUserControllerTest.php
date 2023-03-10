<?php

namespace Tests\Functional\src\Auth\Controller;

use Tests\Functional\src\Auth\AuthControllerTestBase;

class DeauthenticateUserControllerTest extends AuthControllerTestBase
{
    protected string $endpoint = 'api:v1:auth:logout';

    public function test_deauthenticate_user(): void
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => 'Password!1',
        ];

        $this->registerUser($payload);

        $loggedIn = $this->postJson(route('api:v1:auth:login'), $payload);

        $loggedIn->assertOk();
        $loggedIn->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $loggedIn->decodeResponseJson()['success']);
        $this->assertEquals('Logged in.', $loggedIn->decodeResponseJson()['message']);

        $loggedOut = $this->withToken($loggedIn->decodeResponseJson()['data']['token'])
            ->postJson(route($this->endpoint));

        $loggedOut->assertOk();
        $loggedOut->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $loggedOut->decodeResponseJson()['success']);
        $this->assertEquals('Logged out.', $loggedOut->decodeResponseJson()['message']);
        $this->assertNull($loggedOut->decodeResponseJson()['data']);
    }

    public function test_deauthenticate_user_with_non_existing_token(): void
    {
        $token = '1|h0F5Nkx4vAjjPrmJw3RMDX9AH81kgl3xZVZoEzgi';

        $loggedOut = $this->withToken($token)
            ->postJson(route($this->endpoint));

        $loggedOut->assertServerError();
        $loggedOut->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $loggedOut->decodeResponseJson()['success']);
        $this->assertEquals('Unauthenticated.', $loggedOut->decodeResponseJson()['message']);
        $this->assertNull($loggedOut->decodeResponseJson()['data']);
    }
}
