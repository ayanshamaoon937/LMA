<?php

namespace App\Filament\Resources\JobApplicationCvs\Pages;

use App\Filament\Resources\JobApplicationCvs\JobApplicationCvResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobApplicationCv extends EditRecord
{
    protected static string $resource = JobApplicationCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
