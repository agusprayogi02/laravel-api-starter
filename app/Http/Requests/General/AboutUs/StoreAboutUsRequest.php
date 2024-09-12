<?php

namespace App\Http\Requests\General\AboutUs;

use App\Enums\Table;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAboutUsRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'order' => [
                'required', 'numeric',
                Rule::unique(Table::ABOUT_US->value, 'order')
            ],
            'is_active' => 'required',
        ];
    }
}
