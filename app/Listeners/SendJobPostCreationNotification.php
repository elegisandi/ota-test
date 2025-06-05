<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\EmployerFirstJobCreated;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use App\Notifications\EmployerFirstJobPostNotification;

class SendJobPostCreationNotification implements ShouldQueueAfterCommit
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmployerFirstJobCreated $event): void
    {
        $admins = User::admin()->get();

        foreach ($admins as $admin) {
            $admin->notify(new EmployerFirstJobPostNotification($event->jobPost));
        }
    }
}
