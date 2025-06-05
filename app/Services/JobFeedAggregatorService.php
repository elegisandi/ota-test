<?php

namespace App\Services;

use App\Data\JobData;
use App\Models\JobPost;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Contracts\ExternalJobFeedInterface;
use Illuminate\Support\Facades\Concurrency;

final class JobFeedAggregatorService
{
    public const CACHE_KEY = 'job-feed-aggregator';
    public const CACHE_TTL = 3600; // 1 hour in seconds

    public function aggregate(): Collection
    {
        /** @var Collection|null */
        $feed = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            // dd('im here');
            $external_job_feed_interface = app(ExternalJobFeedInterface::class);

            /** @var Collection $external_jobs */
            /** @var Collection $local_jobs */
            [$external_jobs, $local_jobs] = Concurrency::run([
                fn() => $external_job_feed_interface->get(),
                fn() => JobPost::approved()->with('employer')->get(),
            ]);

            /** @var Collection $merged */
            $merged = $external_jobs->merge($local_jobs);

            if ($merged->isEmpty()) {
                return null;
            }

            return $merged;
        });

        if ($feed === null) {
            return collect([]);
        }

        return JobData::collect($feed);
    }

    public function find(string $uuid): ?JobData
    {
        $feed = Cache::get(self::CACHE_KEY);

        if ($feed === null) {
            return null;
        }

        $job = $feed->where('uuid', $uuid)->first();

        if ($job === null) {
            return null;
        }

        return JobData::from($job);
    }

    public function refreshCache(): void
    {
        Cache::forget(self::CACHE_KEY);

        $this->aggregate();
    }
}
