<?php

namespace App\Http\Requests\ThirdPartySystem;

use App\Contracts\DTOMappingContract;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class SendingUserCreateDTO implements DTOMappingContract
{

    public function __construct(public User $user)
    {

    }


    public function mapInto() : Collection|array
    {
        $fullName = $this->user->getFullName();
        $phone = "0" . $this->user->phone;
        return [
            'full_name' => $fullName,
            'mobile_number' => $phone,
            'email' => $this->user->email,
        ];
    }

    public function transformedData() : array
    {
        return $this->mapInto();
    }
}
