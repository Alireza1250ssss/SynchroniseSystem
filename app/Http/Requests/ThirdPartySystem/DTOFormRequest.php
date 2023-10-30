<?php

namespace App\Http\Requests\ThirdPartySystem;

use App\Contracts\DTOMappingContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

abstract class DTOFormRequest extends FormRequest implements DTOMappingContract
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function mapInto() : Collection|array
    {
        return $this->validated();
    }

    public function transformedData(): array|\Illuminate\Support\Collection
    {
        return $this->mapInto();
    }
}
