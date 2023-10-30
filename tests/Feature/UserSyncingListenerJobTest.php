<?php

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Listeners\SyncUserCreateListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserSyncingListenerJobTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_proper_third_party_call_is_done_for_user_create(): void
    {
        Http::fake([
            'api.third-party-system.com/*' => 
                Http::response([],200),
        ]);


        $user = User::factory()->create();
        UserCreated::dispatch($user);

        Http::assertSent(function(Request $request) use($user){
            return $request->url() === 'https://api.third-party-system.com/user/add' &&
                $request['full_name'] === $user->full_name &&
                $request['mobile_number'] === $user->phone &&
                $request['email'] === $user->email ;
        });
    }

    public function test_proper_third_party_call_is_done_for_user_update(): void
    {
        Http::fake([
            'api.third-party-system.com/*' => 
                Http::response([],200),
        ]);


        $user = User::first()->update([
            'first_name' => 'testing'
        ]);
        UserUpdated::dispatch($user);

        Http::assertSent(function(Request $request) use($user){
            return $request->url() === 'https://api.third-party-system.com/user/update' &&
                $request['full_name'] === $user->full_name &&
                $request['mobile_number'] === $user->phone &&
                $request['email'] === $user->email ;
        });
    }

    public function test_proper_third_party_call_is_done_for_user_delete(): void
    {
        Http::fake([
            'api.third-party-system.com/*' => 
                Http::response([],200),
        ]);


        $user = User::first()->delete();
        UserDeleted::dispatch($user);

        Http::assertSent(function(Request $request) use($user){
            return $request->url() === 'https://api.third-party-system.com/user/delete' &&
                $request['mobile_number'] === $user->phone &&
                $request['email'] === $user->email ;
        });
    }
}
