<?php

namespace App\Filament\Resources\Accreditations\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
class AccreditationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                ->image()
                ->disk('public')
                ->directory('accreditations')
                ->imageEditor()
                ->required()
                ->columnSpanFull(),

                Textarea::make('title')
                    ->label('Caption Text')
                    ->rows(2)
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Shown under the logo, e.g. "PROUD MEMBERS OF THE INSTITUTE OF CLERKS OF WORKS AND CONSTRUCTION INSPECTORATE OF GREAT BRITAIN"'),

                TextInput::make('link')
                    ->label('Link (optional)')
                    ->url()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
