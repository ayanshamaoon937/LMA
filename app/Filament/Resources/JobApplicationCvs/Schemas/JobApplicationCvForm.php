<?php

namespace App\Filament\Resources\JobApplicationCvs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class JobApplicationCvForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('File Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('filename')
                                ->label('Filename')
                                ->required()
                                ->maxLength(255),

                            TextInput::make('mime_type')
                                ->label('MIME Type')
                                ->maxLength(255),

                            TextInput::make('file_path')
                                ->label('File Path')
                                ->maxLength(255)
                                ->columnSpanFull(),

                            TextInput::make('file_size')
                                ->label('File Size (bytes)')
                                ->numeric(),
                        ]),
                    ]),
            ]);
    }
}
