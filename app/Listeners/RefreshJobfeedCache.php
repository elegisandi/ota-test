<?php

namespace App\Listeners;

use App\Events\JobPostUpdated;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\JobFeedAggregatorService;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;

class RefreshJobfeedCache implements ShouldQueueAfterCommit
{
    use InteractsWithQueue;

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
    public function handle(JobPostUpdated $event): void
    {
        app(JobFeedAggregatorService::class)->refreshCache();
    }
}
