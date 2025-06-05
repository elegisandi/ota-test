<?php

namespace App\Filament\Employer\Resources\JobPostResource\Pages;

use App\Filament\Employer\Resources\JobPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobPosts extends ListRecords
{
    protected static string $resource = JobPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
