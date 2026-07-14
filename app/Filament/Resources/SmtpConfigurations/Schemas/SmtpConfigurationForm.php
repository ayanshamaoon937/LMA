<?php

namespace App\Filament\Resources\SmtpConfigurations\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;

class SmtpConfigurationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Information')
                    ->description('Configure your SMTP configuration')
                    ->schema([
                        TextInput::make('host')
                            ->required()->maxLength(245),
                        // TextInput::make('port')
                        //     ->required()->maxLength(245),
                        Select::make('port')
                            ->options([
                                // '25' => '25',
                                '465' => '465',
                                '587' => '587',
                            ])->required(),
                        TextInput::make('username')
                            ->required()->maxLength(245),
                        TextInput::make('password')
                            ->required()->maxLength(245),
                        Select::make('encryption')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                            ])->required(),
                        // ->required()->maxLength(245),
                        TextInput::make('from_address')
                            ->required()->maxLength(245),
                        TextInput::make('from_name')
                            ->required()->maxLength(245),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
