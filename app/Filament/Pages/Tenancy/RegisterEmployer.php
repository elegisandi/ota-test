<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Employer;
use App\Models\Team;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterEmployer extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Add Company';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                // ...
            ]);
    }

    protected function handleRegistration(array $data): Employer
    {
        $employer = Employer::create($data);

        $employer->members()->attach(auth('web')->user());

        return $employer;
    }
}
