<?php

namespace App\Filament\Employer\Resources\JobPostResource\Pages;

use Filament\Actions;
use App\Models\JobPost;
use App\Enums\JobPostStatus;
use App\Events\JobPostUpdated;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Employer\Resources\JobPostResource;

class EditJobPost extends EditRecord
{
    protected static string $resource = JobPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function (JobPost $record): void {
                    if ($record->status === JobPostStatus::APPROVED) {
                        event(new JobPostUpdated);
                    }
                }),
        ];
    }

    protected function afterSave(): void
    {
        /** @var JobPost $record */
        $record = $this->record;

        if ($record->status === JobPostStatus::APPROVED) {
            event(new JobPostUpdated);
        }
    }
}
