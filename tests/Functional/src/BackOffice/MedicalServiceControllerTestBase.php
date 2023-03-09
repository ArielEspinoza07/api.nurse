<?php

namespace Tests\Functional\src\BackOffice;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MedicalServiceControllerTestBase extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    protected string $endpoint;


    protected function createMedicalService(string $token, array|null $payload = null): int
    {
        if (!$payload) {
            $payload = [
                'name' => 'Intensive Care Unit',
            ];
        }

        $response = $this->withToken($token)
            ->post(route('api:v1:medical:service:create', $payload));

        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            throw new RuntimeException('Error creating medical service');
        }

        return $response->decodeResponseJson()['data']['id'];
    }


    protected function authToken(): string
    {
        $response = $this->post(route('api:v1:auth:register'), [
            'name' => 'John D',
            'email' => $this->faker->email(),
            'password' => 'Password!1',
            'password_confirmation' => 'Password!1',
        ]);

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new RuntimeException('Error getting token');
        }

        return $response->decodeResponseJson()['data']['token'];
    }
}
