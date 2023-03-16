<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

use function PHPUnit\Framework\assertEquals;

class CountMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:count';


    public function test_count_medical_service_with_criteria(): void
    {
        $token = $this->authToken();

        $services = [
            [
                'name' => 'Emergency',
            ],
            [
                'name' => 'Geriatric',
            ],
            [
                'name' => 'Intensive Care Unit',
            ],
            [
                'name' => 'Orthopaedic ',
            ],
            [
                'name' => 'Pediatrics',
            ],
        ];

        collect($services)
            ->each(function ($service) {
                $this->createMedicalService($service);
            });

        $payload = [
            'filters' => 'name:like:u',
        ];
        $queryString = http_build_query($payload);

        $responseCriteria = $this->withToken($token)
            ->getJson(route($this->endpoint) . sprintf('?%s', $queryString));

        $responseCriteria->assertOk();
        $responseCriteria->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $responseCriteria->decodeResponseJson()['success']);
        $this->assertEquals('Ok.', $responseCriteria->decodeResponseJson()['message']);

        $this->assertArrayHasKey('total', $responseCriteria->decodeResponseJson()['data']);
        $this->assertNotNull($responseCriteria->decodeResponseJson()['data']['total']);
        $this->assertIsInt($responseCriteria->decodeResponseJson()['data']['total']);
        $this->assertEquals(1, $responseCriteria->decodeResponseJson()['data']['total']);
    }

    public function test_count_medical_service_without_criteria(): void
    {
        $token = $this->authToken();

        $services = [
            [
                'name' => 'Emergency',
            ],
            [
                'name' => 'Geriatric',
            ],
            [
                'name' => 'Intensive Care Unit',
            ],
            [
                'name' => 'Orthopaedic ',
            ],
            [
                'name' => 'Pediatrics',
            ],
        ];

        collect($services)
            ->each(function ($service) {
                $this->createMedicalService($service);
            });

        $responseToTal = $this->withToken($token)
            ->getJson(route($this->endpoint));

        $responseToTal->assertOk();
        $responseToTal->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $responseToTal->decodeResponseJson()['success']);
        $this->assertEquals('Ok.', $responseToTal->decodeResponseJson()['message']);

        $this->assertArrayHasKey('total', $responseToTal->decodeResponseJson()['data']);
        $this->assertNotNull($responseToTal->decodeResponseJson()['data']['total']);
        $this->assertIsInt($responseToTal->decodeResponseJson()['data']['total']);
        $this->assertEquals(count($services), $responseToTal->decodeResponseJson()['data']['total']);
    }
}
