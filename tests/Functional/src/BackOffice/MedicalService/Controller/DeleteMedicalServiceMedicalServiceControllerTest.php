<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

class DeleteMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:delete';

    public function test_delete_medical_service(): void
    {
        $token = $this->authToken();

        $medicalServiceId = $this->createMedicalService($token);

        $response = $this->withToken($token)
            ->deleteJson(route($this->endpoint, ['id' => $medicalServiceId]));

        $response->assertNoContent();
    }


    public function test_delete_medical_service_with_non_existing_medical_service(): void
    {
        $token = $this->authToken();

        $medicalServiceId = rand(1, 10);

        $response = $this->withToken($token)
            ->deleteJson(route($this->endpoint, ['id' => $medicalServiceId]));

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
