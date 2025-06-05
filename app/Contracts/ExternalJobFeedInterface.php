<?php

namespace App\Contracts;

interface ExternalJobFeedInterface
{
    public function get(): \Illuminate\Support\Collection;
}
