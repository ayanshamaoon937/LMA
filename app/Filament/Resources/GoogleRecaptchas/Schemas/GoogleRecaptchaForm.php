<?php

namespace App\Filament\Resources\GoogleRecaptchas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class GoogleRecaptchaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_key')
                    ->label('Site Key')
                    ->required(),
                TextInput::make('secret_key')
                    ->label('Secret Key')
                    ->required(),
                    Select::make('version')
                        ->label('Version')
                        ->options([
                            'v2' => 'v2',
                            'v3' => 'v3',
                        ])
                        ->required(),
                Toggle::make('enable')
                    ->label('Enable')
                    ->required(),
            ]);
    }
}
