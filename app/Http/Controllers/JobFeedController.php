<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\JobFeedAggregatorService;

class JobFeedController extends Controller
{
    public function index(JobFeedAggregatorService $jobFeedAggregatorService)
    {
        return Inertia::render('job-feed/index', [
            'jobs' => Inertia::defer(fn() => $jobFeedAggregatorService->aggregate()),
        ]);
    }

    public function show(string $uuid, JobFeedAggregatorService $jobFeedAggregatorService)
    {
        $job = $jobFeedAggregatorService->find($uuid);

        if ($job === null) {
            abort(404, 'Job not found');
        }

        return Inertia::render('job-feed/show', [
            'job' => $job,
        ]);
    }
}
