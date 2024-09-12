<?php

namespace App\Http\Requests\Auth;

use App\Enums\Table;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique(Table::USERS->value, 'email'),
            ],
            'username' => [
                'required',
                Rule::unique(Table::USERS->value, 'username'),
            ],
            'phone' => [
                'nullable',
                Rule::unique(Table::USERS->value, 'phone'),
            ],
            'password' => 'required|confirmed|min:6',
        ];
    }
}
