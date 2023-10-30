<?php

namespace Tests\Feature;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use App\Listeners\SyncUserCreateListener;
use App\Listeners\SyncUserDeleteListener;
use App\Listeners\SyncUserUpdateListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserEntityCRUDEventsTest extends TestCase
{
    
    public function test_user_create_is_synced_properly(): void
    {
        Event::fake();

        $userFactoryData = User::factory()->make();
        $response = $this->post('api/users',$userFactoryData->toArray());

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',$userFactoryData->toArray());
        Event::assertDispatched(UserCreated::class);
        Event::assertListening(UserCreated::class,SyncUserCreateListener::class);
    }

    public function test_user_update_is_synced_properly(): void
    {
        Event::fake();

        $user = User::query()->first();
        $response = $this->put('api/users/'.$user->id,[
            'first_name' => 'testing'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users',$user->refresh()->toArray());
        Event::assertDispatched(UserUpdated::class);
        Event::assertListening(UserUpdated::class,SyncUserUpdateListener::class);
    }

    public function test_user_delete_is_synced_properly(): void
    {
        Event::fake();

        $user = User::first();
        $response = $this->delete('api/users/'.$user->id);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users',$user->toArray());
        Event::assertDispatched(UserDeleted::class);
        Event::assertListening(UserDeleted::class,SyncUserDeleteListener::class);
    }
}
