<?php

namespace App\Filament\Resources\SmtpConfigurations\Pages;

use App\Filament\Resources\SmtpConfigurations\SmtpConfigurationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSmtpConfiguration extends CreateRecord
{
    protected static string $resource = SmtpConfigurationResource::class;
}
