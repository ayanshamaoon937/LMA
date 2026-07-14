<?php

namespace App\Filament\Resources\JobApplicationCvs\Pages;

use App\Filament\Resources\JobApplicationCvs\JobApplicationCvResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobApplicationCvs extends ListRecords
{
    protected static string $resource = JobApplicationCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
