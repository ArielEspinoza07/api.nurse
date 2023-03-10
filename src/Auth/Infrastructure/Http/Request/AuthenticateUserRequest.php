<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthenticateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                Password::min(6)
                    ->mixedCase()
                    ->symbols()
                    ->numbers(),
            ],
        ];
    }
}
