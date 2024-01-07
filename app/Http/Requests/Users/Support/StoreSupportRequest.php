<?php

namespace App\Http\Requests\Users\Support;

use App\Enums\SupportRole;
use App\Models\Support;
use App\Rules\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSupportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Support::class);
    }

    public function rules(): array
    {
        return [
            'role' => ['required', 'string', new Enum(SupportRole::class)],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', new Domain('plataformajunina.com.br'), 'unique:users,email'],
        ];
    }
}
