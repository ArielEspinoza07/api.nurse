<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

class AuthUser
{
    private function __construct(
        private readonly AuthUserId $id,
        private readonly AuthUserName $name,
        private readonly AuthUserEmail $email,
        private readonly AuthUserPassword $password
    ) {
    }

    public static function create(
        AuthUserId $id,
        AuthUserName $name,
        AuthUserEmail $email,
        AuthUserPassword $password
    ): self {
        return new static($id, $name, $email, $password);
    }

    public static function createFromNameEmailAndPassword(
        AuthUserName $name,
        AuthUserEmail $email,
        AuthUserPassword $password
    ): self {
        return new static(AuthUserId::createEmpty(), $name, $email, $password);
    }

    public static function createFromPrimitives(
        int $id,
        string $name,
        string $email,
        bool $emailVerified,
        string $password
    ): self {
        return new static(
            AuthUserId::create($id),
            AuthUserName::create($name),
            AuthUserEmail::create($email, AuthUserEmailVerify::create($emailVerified)),
            AuthUserPassword::create($password)
        );
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

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'email' => $this->email->value(),
            'email_verified' => $this->email->emailVerify()->value(),
        ];
    }
}
