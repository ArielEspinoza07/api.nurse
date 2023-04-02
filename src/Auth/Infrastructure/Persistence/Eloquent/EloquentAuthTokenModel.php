<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * Class EloquentAuthTokenModel
 *
 * @property int id
 * @property string token
 *
 * @property-read MorphTo tokenable
 *
 * @package namespace Src\Auth\Infrastructure\Persistence\Eloquent
 */
class EloquentAuthTokenModel extends PersonalAccessToken
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
