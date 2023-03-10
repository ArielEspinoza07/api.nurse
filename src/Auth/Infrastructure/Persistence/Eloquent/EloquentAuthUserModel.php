<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Auth\Infrastructure\Persistence\Eloquent\Contract\HasApiTokens;
use Illuminate\Foundation\Auth\User as IlluminateAuthUser;

/**
 * Class EloquentAuthUserModel
 *
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @package namespace Src\Auth\Infrastructure\Persistence\Eloquent
 */
class EloquentAuthUserModel extends IlluminateAuthUser
{
    use HasApiTokens;
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $primaryKey = 'id';

    protected $table = 'users';
}
