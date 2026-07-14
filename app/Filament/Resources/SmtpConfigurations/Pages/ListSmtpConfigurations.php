<?php

namespace App\Filament\Resources\SmtpConfigurations\Pages;

use App\Filament\Resources\SmtpConfigurations\SmtpConfigurationResource;
use App\Models\SmtpConfiguration;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ListSmtpConfigurations extends ListRecords
{
    protected static string $resource = SmtpConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        $smtpConfiguration = SmtpConfiguration::first();
        if ($smtpConfiguration) {
            return $this->getResource()::getUrl('edit', ['record' => $smtpConfiguration->id]);
        }
        return $this->getResource()::getUrl('create');
    }

    public function mount(): void
    {
        try {
            $this->redirect($this->getRedirectUrl());
        } catch (ModelNotFoundException $e) {
            $this->redirect($this->getResource()::getUrl('create'));
        }
    }
}
