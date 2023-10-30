<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThirdPartyHooksIncomingCallsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_user_webhook(): void
    {
        // body data could come from a sensible source
        $response = $this->post('/webhook/user',[
            'full_name' => 'firstName lastName',
            'mobile_number' => '09131112233',
            'email' => 'test@email.com',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'first_name' => 'firstName',
            'last_name' => 'lastName' ,
            'phone' => '9131112233',
            'email' => 'test@gmail.com'
        ]);
    }

    /**
     * @depends test_create_user_webhook
     */
    public function test_update_user_webhook(): void
    {
        // body data could come from a sensible source
        $response = $this->put('/webhook/user',[
            'full_name' => 'firstNameChanged lastName',
            'mobile_number' => '09131112233',
            'email' => 'test@email.com',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'first_name' => 'firstNameChanged',
            'last_name' => 'lastName' ,
            'phone' => '9131112233',
            'email' => 'test@gmail.com'
        ]);
    }

    public function test_delete_user_webhook(): void
    {
        // body data could come from a sensible source
        $response = $this->put('/webhook/user',[
            'mobile_number' => '09131112233',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'phone' => '9131112233',
            'email' => 'test@gmail.com'
        ]);
    }
}
