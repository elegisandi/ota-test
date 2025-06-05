<?php

namespace App\Filament\Employer\Resources\JobPostResource\Pages;

use App\Enums\JobPostStatus;
use Filament\Facades\Filament;
use App\Events\EmployerFirstJobCreated;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Employer\Resources\JobPostResource;

class CreateJobPost extends CreateRecord
{
    protected static string $resource = JobPostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth('web')->user();
        $employer = Filament::getTenant();

        $data['status'] = JobPostStatus::PENDING;
        $data['user_id'] = $user->id;
        $data['employer_id'] = $employer->id;

        return $data;
    }

    protected function afterCreate(): void
    {
        $user = auth('web')->user();

        EmployerFirstJobCreated::dispatchIf($user->jobPosts()->count() === 1, $this->record);
    }
}
