<?php

namespace App\Filament\Resources\ProjectCategories\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Category Details')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                                return $operation === 'create' ? $set('slug', Str::slug($state)) : null;
                                            }),

                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->helperText('Used for the article URL. Auto-filled from the title, but you can edit it.'),

                                        FileUpload::make('hero_image')
                                            ->label('Hero Image')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->disk('public')
                                            ->directory('projects_categories'),

                                        TextInput::make('hero_subtitle')
                                            ->label('Hero Subtitle'),

                                        RichEditor::make('hero_description')
                                            ->label('Hero Description')
                                            ->columnSpanFull(),

                                    ])->columns(2),
                            ])
                            ->columnSpan(['lg' => 2]),

                        Group::make()
                            ->schema([
                                Section::make('Settings')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->default(true)
                                            ->required(),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 2]),
                    ])->columnSpanFull(),
            ]);
    }
}
