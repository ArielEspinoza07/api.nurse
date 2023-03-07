<?php

namespace Tests\Functional\src\BackOffice;

use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MedicalServiceControllerTestBase extends TestCase
{
    use RefreshDatabase;

    protected string $endpoint;

    protected function createMedicalService(array|null $payload = null): int
    {
        if (!$payload) {
            $payload = [
                'name' => 'Intensive Care Unit',
            ];
        }

        $response = $this->post(route('api:v1:medical:service:create', $payload));

        if (Response::HTTP_CREATED !== $response->getStatusCode()) {
            throw new RuntimeException('Error creating medical service');
        }

        return $response->decodeResponseJson()['data']['id'];
    }
}
