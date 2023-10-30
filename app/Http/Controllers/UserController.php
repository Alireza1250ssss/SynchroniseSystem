<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::query()->create($request->validated());

        UserCreated::dispatch($user);

        return response()->success(
            message: __('messages.created', ['resource' => 'user']),
            data: $user
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        UserUpdated::dispatch($user);

        return response()->success(
            message: __('messages.updated', ['resource' => 'user']),
            data: $user
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $status = $user->delete();

        UserDeleted::dispatch($user);

        return response()->success(
            message: $status ?
                __('messages.deleted', ['resource' => 'user']) :
                __('messages.delete_fail'),
            data: [
                'status' => $status,
            ]
        );
    }
}
