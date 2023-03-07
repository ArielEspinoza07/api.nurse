<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()
                    ->symbols()
                    ->numbers()
                    ->uncompromised(),
            ],
        ];
    }
}
