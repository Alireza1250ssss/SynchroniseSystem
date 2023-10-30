<?php

namespace App\Http\Requests\ThirdPartySystem;

use App\Contracts\DTOMappingContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class UpsertUserDTO extends DTOFormRequest implements DTOMappingContract
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required', // example : 'Alireza Salehi'
            'mobile_number' => 'required|size:11', // example : '09134809830'
            'email' => 'required|email'
        ];
    }

    public function mapInto(): Collection|array
    {
        [$firstName, $lastName] = explode(" ", $this->full_name);
        $phone = ltrim($this->mobile_number, "0");
        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $this->email
        ];
    }
}
