<?php

namespace App\Filament\Admin\Resources;

use Filament\Tables;
use App\Models\JobPost;
use Filament\Tables\Table;
use App\Enums\JobPostStatus;
use App\Events\JobPostUpdated;
use Filament\Resources\Resource;
use App\Filament\Admin\Resources\JobPostResource\Pages;

class JobPostResource extends Resource
{
    protected static ?string $model = JobPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->description(fn(JobPost $record): string => substr(strip_tags($record->description), 0, 50))
                    ->lineClamp(2)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('employer.name')
                    ->label('Company')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('employment_type')
                    ->label('Employment Type')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Posted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->action(function (JobPost $record): void {
                        $record->update(['status' => JobPostStatus::APPROVED]);

                        event(new JobPostUpdated);
                    })
                    ->icon('heroicon-o-hand-thumb-up')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(JobPost $record): bool => $record->status === JobPostStatus::PENDING),
                Tables\Actions\Action::make('reject')
                    ->action(function (JobPost $record): void {
                        $record->update(['status' => JobPostStatus::SPAM]);
                    })
                    ->icon('heroicon-o-hand-thumb-down')
                    ->label('Spam')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn(JobPost $record): bool => $record->status === JobPostStatus::PENDING),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobPosts::route('/'),
            'view' => Pages\ViewJobPost::route('/{record}'),
        ];
    }
}
