<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Src\Auth\Infrastructure\Persistence\Eloquent\Contract\HasApiTokens;
use Illuminate\Foundation\Auth\User as IlluminateAuthUser;

/**
 * Class EloquentAuthUserModel
 *
 * @property int id
 * @property string name
 * @property string email
 * @property Carbon email_verified_at
 * @property string password
 *
 * @property-read EloquentAuthTokenModel[]|Collection|null tokens
 *
 * @package namespace Src\Auth\Infrastructure\Persistence\Eloquent
 */
class EloquentAuthUserModel extends IlluminateAuthUser
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
    ];

    protected $guarded = [];
}
