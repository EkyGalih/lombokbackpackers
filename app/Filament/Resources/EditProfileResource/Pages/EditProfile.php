<?php

namespace App\Filament\Resources\EditProfileResource\Pages;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent()
                            ->label('Full Name'),

                        $this->getEmailFormComponent()
                            ->label('Email Address'),

                        $this->getPasswordFormComponent(),

                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(! static::isSimple()),
            ),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        // redirect ke dashboard admin setelah berhasil update
        return url('/admin');
    }
}
