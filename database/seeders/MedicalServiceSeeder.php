<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceModel;

class MedicalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
                EloquentMedicalServiceModel::query()
                    ->create($service);
            });
    }
}
