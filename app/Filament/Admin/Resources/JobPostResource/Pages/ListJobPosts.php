<?php

namespace App\Filament\Admin\Resources\JobPostResource\Pages;

use Filament\Actions;
use App\Models\JobPost;
use App\Enums\JobPostStatus;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Admin\Resources\JobPostResource;

class ListJobPosts extends ListRecords
{
    protected static string $resource = JobPostResource::class;

    public function getTabs(): array
    {
        return [
            'pending' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', JobPostStatus::PENDING)),
            'approved' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', JobPostStatus::APPROVED)),
            'spam' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('status', JobPostStatus::SPAM)),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'pending';
    }
}
