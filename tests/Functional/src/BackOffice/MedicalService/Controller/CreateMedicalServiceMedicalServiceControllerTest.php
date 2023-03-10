<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

use function PHPUnit\Framework\assertEquals;

class CreateMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:create';


    public function test_create_medical_service(): void
    {
        $token = $this->authToken();

        $payload = [
            'name' => 'Intensive Care Unit'
        ];

        $responseCreated = $this->withToken($token)
            ->postJson(route($this->endpoint), $payload);

        $responseCreated->assertCreated();
        $responseCreated->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $responseCreated->decodeResponseJson()['success']);
        $this->assertEquals('Created.', $responseCreated->decodeResponseJson()['message']);

        $this->assertArrayHasKey('id', $responseCreated->decodeResponseJson()['data']);
        $this->assertNotNull($responseCreated->decodeResponseJson()['data']['id']);
        $this->assertIsInt($responseCreated->decodeResponseJson()['data']['id']);
        $this->assertEquals($payload['name'], $responseCreated->decodeResponseJson()['data']['name']);

        $generatedMedicalServiceId = $responseCreated->decodeResponseJson()['data']['id'];

        $responseFounded = $this->withToken($token)
            ->getJson(
                route(
                    'api:v1:medical:service:show',
                    [
                        'id' => $generatedMedicalServiceId
                    ]
                )
            );

        $responseFounded->assertOk();
        $responseFounded->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $responseFounded->decodeResponseJson()['success']);
        $this->assertEquals('Found.', $responseFounded->decodeResponseJson()['message']);

        $this->assertEquals($generatedMedicalServiceId, $responseFounded->decodeResponseJson()['data']['id']);
        $this->assertEquals($payload['name'], $responseFounded->decodeResponseJson()['data']['name']);
    }
}
