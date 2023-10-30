<?php

namespace App\Http\Controllers\ThirdPartyHooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThirdPartySystem\DeleteUserDTO;
use App\Http\Requests\ThirdPartySystem\UpsertUserDTO;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function updateOrStore(UpsertUserDTO $userDTO)
    {
        $userData = $userDTO->transformedData();
        $user = User::query()->updateOrCreate([
            ['phone' => $userData['phone']],
            Arr::except($userData,['phone'])
        ]);
        return response()->success(data: $user);
    }

    public function destroy(DeleteUserDTO $userDTO)
    {
        $count = User::query()->where($userDTO->transformedData())->delete();
        return response()->success(message: __('messages.delete_batch',['batch' => $count]));
    }

    public function index(Request $request)
    {
        // the pagination in for safety if there would be millions of records !
        $users = User::query()->paginate($request->get('per_page',10));
        return response()->success(data: $users);
    }
}
