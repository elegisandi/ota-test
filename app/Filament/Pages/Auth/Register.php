<?php

namespace App\Filament\Pages\Auth;

use App\Enums\UserRole;

final class Register extends \Filament\Pages\Auth\Register
{
    /**
     * Set user role to Employer
     *
     * @param array $data
     * @return array
     */
    protected function mutateFormDataBeforeRegister(array $data): array
    {
        $data['role'] = UserRole::EMPLOYER;

        return $data;
    }
}
