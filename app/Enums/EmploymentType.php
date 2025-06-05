<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Filament\Support\Contracts\HasLabel;

enum EmploymentType: int implements HasLabel
{
    case FULL_TIME = 1;
    case PART_TIME = 2;
    case CONTRACT = 3;
    case TEMPORARY = 4;
    case INTERN = 5;
    case VOLUNTEER = 6;
    case UNKNOWN = 7;

    public function getLabel(): string
    {
        return Str::of($this->name)
            ->replace('_', ' ')
            ->title()
            ->toString();
    }
}
