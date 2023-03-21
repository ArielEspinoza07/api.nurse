<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Database\Seeders\MedicalServiceSeeder;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceModel;
use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

use function PHPUnit\Framework\assertEquals;

class CountMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{
    protected string $endpoint = 'api:v1:medical:service:count';


    public function test_count_medical_service_with_criteria(): void
    {
        $this->seed(MedicalServiceSeeder::class);

        $token = $this->authToken();

        $foundServices = EloquentMedicalServiceModel::query()->where('name', 'like', '%u%')->count();

        $payload = [
            'filters' => 'name:like:u',
        ];
        $queryString = http_build_query($payload);

        $response = $this->withToken($token)
            ->getJson(route($this->endpoint) . sprintf('?%s', $queryString));

        $response->assertOk();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $response->decodeResponseJson()['success']);
        $this->assertEquals('Ok.', $response->decodeResponseJson()['message']);

        $this->assertArrayHasKey('total', $response->decodeResponseJson()['data']);
        $this->assertNotNull($response->decodeResponseJson()['data']['total']);
        $this->assertIsInt($response->decodeResponseJson()['data']['total']);
        $this->assertEquals($foundServices, $response->decodeResponseJson()['data']['total']);
    }

    public function test_count_medical_service_without_criteria(): void
    {
        $this->seed(MedicalServiceSeeder::class);

        $token = $this->authToken();

        $foundServices = EloquentMedicalServiceModel::query()->count();

        $response = $this->withToken($token)
            ->getJson(route($this->endpoint));

        $response->assertOk();
        $response->assertJsonStructure([
            "success",
            "message",
            "data",
        ]);

        $this->assertEquals(true, $response->decodeResponseJson()['success']);
        $this->assertEquals('Ok.', $response->decodeResponseJson()['message']);

        $this->assertArrayHasKey('total', $response->decodeResponseJson()['data']);
        $this->assertNotNull($response->decodeResponseJson()['data']['total']);
        $this->assertIsInt($response->decodeResponseJson()['data']['total']);
        $this->assertEquals($foundServices, $response->decodeResponseJson()['data']['total']);
    }
}
