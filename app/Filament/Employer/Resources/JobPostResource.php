<?php

namespace App\Filament\Employer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\JobPost;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\EmploymentType;
use Filament\Resources\Resource;
use App\Filament\Employer\Resources\JobPostResource\Pages;

class JobPostResource extends Resource
{
    protected static ?string $model = JobPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('location')
                    ->required(),
                Forms\Components\Select::make('employment_type')
                    ->label('Employment Type')
                    ->options(EmploymentType::class)
                    ->native(false)
                    ->required(),
            ])
            ->columns(2);
    }

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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateJobPost::route('/create'),
            'edit' => Pages\EditJobPost::route('/{record}/edit'),
        ];
    }
}
