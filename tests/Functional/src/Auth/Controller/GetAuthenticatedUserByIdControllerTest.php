<?php

namespace Tests\Functional\src\Auth\Controller;

use Tests\Functional\src\Auth\AuthControllerTestBase;

class GetAuthenticatedUserByIdControllerTest extends AuthControllerTestBase
{
    protected string $endpoint = 'api:v1:auth:user';

    public function test_get_user(): void
    {
        $payload = [
            'email' => $this->faker->email(),
            'password' => 'Api.nurse!1',
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
        $this->assertEquals('Authenticated user retrieved.', $loggedOut->decodeResponseJson()['message']);
        $this->assertNotNull($loggedOut->decodeResponseJson()['data']);
        $this->assertIsArray($loggedOut->decodeResponseJson()['data']);
    }

    public function test_get_non_existing_user(): void
    {
        $token = '1|h0F5Nkx4vAjjPrmJw3RMDX9AH81kgl3xZVZoEzgi';

        $loggedOut = $this->withToken($token)
            ->postJson(route($this->endpoint));

        $loggedOut->assertUnauthorized();
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
