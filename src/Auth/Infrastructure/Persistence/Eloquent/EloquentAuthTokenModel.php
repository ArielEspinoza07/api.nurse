<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Src\shared\Infrastructure\Persistence\Eloquent\EloquentSanctumTokenBaseModel;

/**
 * Class EloquentAuthUserModel
 *
 * @property string $name
 * @property string $password
 *
 * @package namespace Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent
 */
class EloquentAuthTokenModel extends EloquentSanctumTokenBaseModel
{
    protected $primaryKey = 'id';

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'expires_at',
    ];
}
