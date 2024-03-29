<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

class UpdateMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:update';

    public function test_update_medical_service(): void
    {
        $token = $this->authToken();

        $medicalServiceId = $this->createMedicalService();

        $payload = [
            'name' => 'Pediatrics',
        ];

        $response = $this->withToken($token)
            ->patchJson(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

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
        $token = $this->authToken();

        $medicalServiceId = $this->createMedicalService();

        $payload = [
            'name' => 'OT',
        ];

        $response = $this->withToken($token)
            ->patchJson(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

        $response->assertBadRequest();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(false, $response->decodeResponseJson()['success']);
        $this->assertEquals(
            sprintf('Invalid argument [%s], value must be min %s', $payload['name'], MedicalServiceName::MINIMUM_LENGTH),
            $response->decodeResponseJson()['message']
        );
    }

    public function test_update_medical_service_with_non_existing_medical_service(): void
    {
        $token = $this->authToken();

        $medicalServiceId = rand(1, 10);

        $payload = [
            'name' => 'Pediatrics',
        ];

        $response = $this->withToken($token)
            ->patchJson(route($this->endpoint, ['id' => $medicalServiceId]), $payload);

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
