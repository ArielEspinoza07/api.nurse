<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Src\Auth\Infrastructure\Persistence\Eloquent\Contract\HasApiTokens;
use Src\shared\Infrastructure\Persistence\Eloquent\EloquentBaseModel;

/**
 * Class EloquentAuthUserModel
 *
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @package namespace Src\Auth\Infrastructure\Persistence\Eloquent
 */
class EloquentAuthUserModel extends EloquentBaseModel
{

    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $primaryKey = 'id';

    protected $table = 'users';
}
