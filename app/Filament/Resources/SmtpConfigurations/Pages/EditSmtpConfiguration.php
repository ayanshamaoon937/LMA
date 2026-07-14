<?php

namespace App\Filament\Resources\SmtpConfigurations\Pages;

use App\Filament\Resources\SmtpConfigurations\SmtpConfigurationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSmtpConfiguration extends EditRecord
{
    protected static string $resource = SmtpConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
