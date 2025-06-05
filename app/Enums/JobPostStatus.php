<?php

namespace App\Enums;

use Illuminate\Support\Str;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum JobPostStatus: int implements HasColor, HasLabel
{
    case PENDING = 0;
    case APPROVED = 1;
    case SPAM = 2;

    public function getLabel(): string
    {
        return Str::title($this->name);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::APPROVED => 'success',
            self::SPAM => 'danger',
        };
    }
}
