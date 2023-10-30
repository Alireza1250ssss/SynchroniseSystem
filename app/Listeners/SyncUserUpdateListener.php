<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Http\Requests\ThirdPartySystem\SendingUserCreateDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SyncUserUpdateListener implements ShouldQueue
{
    use InteractsWithQueue;
   public $tries = 3;

    /**
     * sync third party system database with new user.
     */
    public function handle(UserUpdated $event): void
    {
        $userDTO = new SendingUserCreateDTO($event->user);

        Http::thirdPartySystem()->post('users/update', $userDTO->transformedData())->throw();
    }

    public function failed(UserUpdated $event): void
    {
        // report a log or notification or try another way for syncing
    }
}
