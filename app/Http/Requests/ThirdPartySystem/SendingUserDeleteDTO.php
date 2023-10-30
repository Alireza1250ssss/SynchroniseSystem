<?php

namespace App\Http\Requests\ThirdPartySystem;

use App\Contracts\DTOMappingContract;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class SendingUserDeleteDTO implements DTOMappingContract
{
    public function __construct(public User $user)
    {

    }


    public function mapInto() : Collection|array
    {
        /* in the third party system user in uniqued by mobile number and email 
        and we must provide both of them to identify a user for delete */
        $phone = "0" . $this->user->phone;
        return [
            'mobile_number' => $phone,
            'email' => $this->user->email,
        ];
    }

    public function transformedData() : array
    {
        return $this->mapInto();
    }
}
