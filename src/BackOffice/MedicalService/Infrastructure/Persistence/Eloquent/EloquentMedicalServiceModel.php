<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent;

use Src\shared\Infrastructure\Persistence\Eloquent\EloquentBaseModel;

/**
 * Class EloquentMedicalServiceModel
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 *
 * @package namespace Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent
 */
class EloquentMedicalServiceModel extends EloquentBaseModel
{
    protected $casts = [
        'is_active' => 'bool',
    ];

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $primaryKey = 'id';

    protected $table = 'medical_services';
}
