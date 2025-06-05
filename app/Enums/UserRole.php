<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum UserRole: int
{
    case ADMIN = 1;
    case JOBSEEKER = 2;
    case EMPLOYER = 3;

    /**
     * Get the label for the role.
     */
    public function label(): string
    {
        return Str::title($this->name);
    }
}
