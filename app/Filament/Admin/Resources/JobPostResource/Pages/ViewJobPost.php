<?php

namespace App\Filament\Admin\Resources\JobPostResource\Pages;

use App\Models\JobPost;
use App\Enums\JobPostStatus;
use Filament\Actions\Action;
use App\Events\JobPostUpdated;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Group;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Admin\Resources\JobPostResource;

class ViewJobPost extends ViewRecord
{
    protected static string $resource = JobPostResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Group::make([
                    TextEntry::make('title')
                        ->size(TextEntry\TextEntrySize::Medium)
                        ->weight(FontWeight::Bold),
                    TextEntry::make('location')
                        ->size(TextEntry\TextEntrySize::Medium),
                    TextEntry::make('employment_type')
                        ->label('Employment Type')
                        ->size(TextEntry\TextEntrySize::Medium),
                    TextEntry::make('status')
                        ->badge()
                        ->size(TextEntry\TextEntrySize::Medium),
                    TextEntry::make('created_at')
                        ->label('Posted At')
                        ->dateTime()
                        ->size(TextEntry\TextEntrySize::Medium),
                    TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->dateTime()
                        ->size(TextEntry\TextEntrySize::Medium),
                ])
                    ->columns(2)
                    ->columnSpanFull(),

                Group::make([
                    TextEntry::make('description')
                        ->html()
                        ->extraAttributes([
                            'class' => 'border border-gray-100 p-4 rounded',
                        ]),
                ])
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->icon('heroicon-m-hand-thumb-up')
                ->color('success')
                ->requiresConfirmation()
                ->action(function (JobPost $record): void {
                    $record->update(['status' => JobPostStatus::APPROVED]);

                    event(new JobPostUpdated);

                    Notification::make()
                        ->title('Job Post Approved')
                        ->body('The job post has been approved.')
                        ->success()
                        ->send();
                })
                ->visible(fn(JobPost $record): bool => $record->status === JobPostStatus::PENDING),
            Action::make('resetStars')
                ->icon('heroicon-m-hand-thumb-down')
                ->label('Mark as Spam')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function (JobPost $record): void {
                    $record->update(['status' => JobPostStatus::SPAM]);

                    Notification::make()
                        ->title('Job Post Marked as Spam')
                        ->body('The job post has been marked as spam.')
                        ->success()
                        ->send();
                })
                ->visible(fn(JobPost $record): bool => $record->status === JobPostStatus::PENDING),
        ];
    }
}
