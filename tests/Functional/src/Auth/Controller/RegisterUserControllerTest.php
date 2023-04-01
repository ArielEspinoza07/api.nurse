<?php

namespace Tests\Functional\src\Auth\Controller;

use Tests\Functional\src\Auth\AuthControllerTestBase;

class RegisterUserControllerTest extends AuthControllerTestBase
{
    protected string $endpoint = 'api:v1:auth:register';

    public function test_register_user(): void
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'Api.nurse!1',
            'password_confirmation' => 'Api.nurse!1',
        ];

        $registered = $this->postJson(route($this->endpoint), $payload);

        $registered->assertOk();
        $registered->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $registered->decodeResponseJson()['success']);
        $this->assertEquals('Registered.', $registered->decodeResponseJson()['message']);

        $this->assertArrayHasKey('token', $registered->decodeResponseJson()['data']);
        $this->assertNotNull($registered->decodeResponseJson()['data']['token']);
        $this->assertIsString($registered->decodeResponseJson()['data']['token']);
    }

    public function test_register_user_with_wrong_password_expect_unprocessable_entity(): void
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'Password!',
            'password_confirmation' => 'Password!1',
        ];

        $registered = $this->postJson(route($this->endpoint), $payload);

        $registered->assertUnprocessable();
        $registered->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $registered->decodeResponseJson()['success']);
        $this->assertEquals(
            'The password field confirmation does not match. (and 1 more error)',
            $registered->decodeResponseJson()['message']
        );

        $this->assertArrayHasKey('password', $registered->decodeResponseJson()['data']);
        $this->assertNotNull($registered->decodeResponseJson()['data']['password']);
        $this->assertIsArray($registered->decodeResponseJson()['data']['password']);
    }

    public function test_register_user_with_existing_email(): void
    {
        $payload = [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => 'Api.nurse!1',
            'password_confirmation' => 'Api.nurse!1',
        ];

        $this->registerUser($payload);

        $registered = $this->postJson(route($this->endpoint), $payload);

        $registered->assertBadRequest();
        $registered->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);


        $this->assertEquals(false, $registered->decodeResponseJson()['success']);
        $this->assertEquals(
            'Registration failed: The email is already associated with an account.',
            $registered->decodeResponseJson()['message']
        );
        $this->assertNull($registered->decodeResponseJson()['data']);
    }
}
