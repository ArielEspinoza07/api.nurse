<?php

namespace Tests\Functional\src\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTestBase extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected string $endpoint;

    protected function registerUser(array $payload): void
    {
        $payload['name'] = $this->faker->name();
        $payload['password_confirmation'] = $payload['password'];

        $response = $this->post(route('api:v1:auth:register'), $payload);

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new RuntimeException('Error registering user');
        }
    }
}
