<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Http\Requests\ThirdPartySystem\SendingUserDeleteDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SyncUserDeleteListener implements ShouldQueue
{
    use InteractsWithQueue;
   public $tries = 3;

    /**
     * sync third party system database with deleted user.
     */
    public function handle(UserDeleted $event): void
    {
        $userDTO = new SendingUserDeleteDTO($event->user);

        Http::thirdPartySystem()->delete('users/delete', $userDTO->transformedData())->throw();
    }

    public function failed(UserDeleted $event): void
    {
        // report a log or notification or try another way for syncing
    }
}
