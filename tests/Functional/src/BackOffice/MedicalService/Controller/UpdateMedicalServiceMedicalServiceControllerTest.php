<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

class UpdateMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:update';

    public function test_update_medical_service(): void
    {
        $medicalServiceId = $this->createMedicalService();

        $payload = [
            'name' => 'Pediatrics',
            'is_active' => true,
        ];

        $response = $this->put(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

        $response->assertOk();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $response->decodeResponseJson()['success']);
        $this->assertEquals('Updated.', $response->decodeResponseJson()['message']);

        $this->assertEquals($medicalServiceId, $response->decodeResponseJson()['data']['id']);
        $this->assertEquals($payload['name'], $response->decodeResponseJson()['data']['name']);
    }

    public function test_update_medical_service_with_wrong_value(): void
    {
        $medicalServiceId = $this->createMedicalService();

        $payload = [
            'name' => 'OT',
        ];

        $response = $this->put(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

        $response->assertBadRequest();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $response->decodeResponseJson()['success']);
        $this->assertEquals(
            sprintf('Invalid argument [%s], value must be min 3', $payload['name']),
            $response->decodeResponseJson()['message']
        );
    }

    public function test_update_medical_service_with_non_existing_medical_service(): void
    {
        $medicalServiceId = rand(1, 10);

        $payload = [
            'name' => 'Pediatrics',
            'is_active' => true,
        ];

        $response = $this->put(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

        $response->assertNotFound();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $response->decodeResponseJson()['success']);
        $this->assertEquals('Medical Service Not Found', $response->decodeResponseJson()['message']);
    }
}
