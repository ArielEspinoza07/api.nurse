<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

class AuthUser
{
    public function __construct(
        private readonly AuthUserId $id,
        private readonly AuthUserName $name,
        private readonly AuthUserEmail $email,
        private readonly AuthUserPassword $password,
        private readonly AuthUserToken $token
    ) {
    }

    public static function create(
        AuthUserId $id,
        AuthUserName $name,
        AuthUserEmail $email,
        AuthUserPassword $password,
        AuthUserToken $token
    ): self {
        return new static($id, $name, $email, $password, $token);
    }

    public static function createFromEmailAndPassword(AuthUserEmail $email, AuthUserPassword $password): self
    {
        return self::create(AuthUserId::random(), AuthUserName::random(), $email, $password, new AuthUserToken(''));
    }

    public static function createFromNameEmailAndPassword(
        AuthUserName $name,
        AuthUserEmail $email,
        AuthUserPassword $password
    ): self {
        return self::create(AuthUserId::random(), $name, $email, $password, new AuthUserToken(''));
    }

    public function id(): AuthUserId
    {
        return $this->id;
    }

    public function email(): AuthUserEmail
    {
        return $this->email;
    }

    public function name(): AuthUserName
    {
        return $this->name;
    }

    public function password(): AuthUserPassword
    {
        return $this->password;
    }

    public function token(): AuthUserToken
    {
        return $this->token;
    }
}
