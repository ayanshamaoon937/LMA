<?php

namespace App\Filament\Resources\Jobs\Schemas;

use App\Enums\EmploymentType;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;


class JobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Job Details')
                ->description('These appear as cards in the "Open Positions" section, and feed the "Position Applying For" dropdown on the application form.')
                ->schema([

                Grid::make(2)
                        ->schema([
                    TextInput::make('title')
                        ->label('Job Title')
                        ->placeholder('e.g. Clerk of Works')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set, $context) {
                            if ($context === 'create') {
                                $set('slug', \Illuminate\Support\Str::slug($state));
                            }
                        }),

                    TextInput::make('slug')
                        ->label('URL Slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->helperText('Used if you add a dedicated job page later.'),
                    ]),
                    Grid::make(2)
                        ->schema([
                            TextInput::make('location')
                                ->label('Location')
                                ->placeholder('e.g. London'),

                            Select::make('employment_type')
                                ->label('Employment Type')
                                ->options(EmploymentType::class) // Dynamic and centralized!
                                ->native(false),
                        ]),

                    Textarea::make('description')
                        ->label('Short Description')
                        ->helperText('Shown on the card in the Open Positions section.')
                        ->rows(3)
                        ->maxLength(255)
                        ->columnSpanFull(),

                    // RichEditor::make('full_description')
                    //     ->label('Full Description (optional)')
                    //     ->helperText('For a future dedicated job page — not shown on the careers page yet.')
                    //     ->columnSpanFull(),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('sort_order')
                                ->label('Sort Order')
                                ->numeric()
                                ->default(0)
                                ->helperText('Lower numbers appear first.'),

                            Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->helperText('Turn off to hide without deleting. Closed roles should be turned off.'),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
