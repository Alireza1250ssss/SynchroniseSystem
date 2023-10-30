<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes',
            'last_name' => 'sometimes',
            'email' => 'sometimes|email',
            'phone' => [
                'sometimes', 'integer', 'size:10',
                Rule::unique('users', 'phone')->ignore($this->route('user')->id)
            ]
        ];
    }
}
