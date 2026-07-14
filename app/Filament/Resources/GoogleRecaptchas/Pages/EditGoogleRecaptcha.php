<?php

namespace App\Filament\Resources\GoogleRecaptchas\Pages;

use App\Filament\Resources\GoogleRecaptchas\GoogleRecaptchaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGoogleRecaptcha extends EditRecord
{
    protected static string $resource = GoogleRecaptchaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
