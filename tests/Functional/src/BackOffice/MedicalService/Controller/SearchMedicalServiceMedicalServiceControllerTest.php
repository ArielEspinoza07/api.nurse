<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

class SearchMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{

    protected string $endpoint = 'api:v1:medical:service:index';

    public function test_search_all_medical_services_without_criteria(): void
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
            ->each(function ($service) use(&$token) {
                $this->createMedicalService($token ,$service);
            });

        $response = $this->withToken($token)
                         ->get(route($this->endpoint));

        $response->assertOk();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $response->decodeResponseJson()['success']);
        $this->assertEquals('Retrieved all.', $response->decodeResponseJson()['message']);

        $this->assertNotNull($response->decodeResponseJson()['data']);
        $this->assertIsArray($response->decodeResponseJson()['data']);
        $this->assertCount(count($services), $response->decodeResponseJson()['data']);
    }

    public function test_search_all_medical_services_with_criteria(): void
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
            ->each(function ($service) use(&$token) {
                $this->createMedicalService($token ,$service);
            });

        $payload = [
            'filters' => 'name:like:ic',
            'order' => [
                'by' => 'created_at',
                'type' => 'asc',
            ],
            'page' => 1,
            'limit' => 2,
        ];

        $queryString = http_build_query($payload);

        $response = $this->withToken($token)
                         ->get(route($this->endpoint).sprintf('?%s',$queryString));

        $response->assertOk();
        $response->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "items",
                "meta",
            ],
        ]);

        $this->assertEquals(true, $response->decodeResponseJson()['success']);
        $this->assertEquals('Retrieved all.', $response->decodeResponseJson()['message']);

        $this->assertNotNull($response->decodeResponseJson()['data']);
        $this->assertIsArray($response->decodeResponseJson()['data']);
    }
}
