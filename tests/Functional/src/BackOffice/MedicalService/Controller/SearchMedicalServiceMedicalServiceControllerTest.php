<?php

namespace Tests\Functional\src\BackOffice\MedicalService\Controller;

use Database\Seeders\MedicalServiceSeeder;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceModel;
use Tests\Functional\src\BackOffice\MedicalServiceControllerTestBase;

class SearchMedicalServiceMedicalServiceControllerTest extends MedicalServiceControllerTestBase
{

    protected string $endpoint = 'api:v1:medical:service:index';

    public function test_search_medical_services_without_criteria(): void
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
        $this->assertEquals('Retrieved all.', $response->decodeResponseJson()['message']);

        $this->assertNotNull($response->decodeResponseJson()['data']);
        $this->assertIsArray($response->decodeResponseJson()['data']);
        $this->assertCount($foundServices, $response->decodeResponseJson()['data']);
    }

    public function test_search_medical_services_with_criteria(): void
    {
        $this->seed(MedicalServiceSeeder::class);

        $token = $this->authToken();

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
            ->getJson(route($this->endpoint) . sprintf('?%s', $queryString));

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

        $this->assertNotNull($response->decodeResponseJson()['data']['items']);
        $this->assertIsArray($response->decodeResponseJson()['data']['items']);
        $this->assertCount(2, $response->decodeResponseJson()['data']['items']);

        $this->assertNotNull($response->decodeResponseJson()['data']['meta']);
        $this->assertIsArray($response->decodeResponseJson()['data']['meta']);


        $nextPage = collect($response->decodeResponseJson()['data']['meta']['links'])
            ->where('label', 'Next &raquo;')
            ->whereNotNull('url')
            ->first();

        $responseNextPage = $this->withToken($token)
            ->getJson($nextPage['url']);

        $responseNextPage->assertOk();
        $responseNextPage->assertJsonStructure([
            "success",
            "message",
            "data" => [
                "items",
                "meta",
            ],
        ]);

        $this->assertEquals(true, $responseNextPage->decodeResponseJson()['success']);
        $this->assertEquals('Retrieved all.', $responseNextPage->decodeResponseJson()['message']);

        $this->assertNotNull($responseNextPage->decodeResponseJson()['data']);
        $this->assertIsArray($responseNextPage->decodeResponseJson()['data']);

        $this->assertNotNull($responseNextPage->decodeResponseJson()['data']['items']);
        $this->assertIsArray($responseNextPage->decodeResponseJson()['data']['items']);
        $this->assertCount(1, $responseNextPage->decodeResponseJson()['data']['items']);

        $this->assertNotNull($responseNextPage->decodeResponseJson()['data']['meta']);
        $this->assertIsArray($responseNextPage->decodeResponseJson()['data']['meta']);
    }
}
