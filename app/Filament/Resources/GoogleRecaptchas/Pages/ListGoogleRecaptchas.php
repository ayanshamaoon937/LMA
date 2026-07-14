<?php

namespace App\Filament\Resources\GoogleRecaptchas\Pages;

use App\Filament\Resources\GoogleRecaptchas\GoogleRecaptchaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\GoogleRecaptcha;

class ListGoogleRecaptchas extends ListRecords
{
    protected static string $resource = GoogleRecaptchaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }


    protected function getRedirectUrl(): string
    {
        // Check if a Website Heading entry exists
        $GoogleRecaptcha = GoogleRecaptcha::first();
        // If no entry exists, redirect to the create page
        if (!$GoogleRecaptcha) {
            return $this->getResource()::getUrl('create');
        }
        // If an entry exists, redirect to the edit page
        return $this->getResource()::getUrl('edit', ['record' => $GoogleRecaptcha->id]);
    }


    public function mount(): void
    {
        // Prevent access to the index page, redirect to edit or create
        try {
            $this->redirect($this->getRedirectUrl());
        } catch (ModelNotFoundException $e) {
            $this->redirect($this->getResource()::getUrl('create'));
        }
    }
}
