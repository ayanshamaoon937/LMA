<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        Group::make()
                            ->schema([
                                Section::make('Article Content')
                                    ->schema([
                                        TextInput::make('title')
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
                                            
                                        RichEditor::make('content')
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Media')
                                    ->schema([
                                        FileUpload::make('image')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->required()
                                            ->maxSize(2048)
                                            ->disk('public')
                                            ->directory('news')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 2]),

                        Group::make()
                            ->schema([
                                Section::make('Publishing')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Published')
                                            ->default(true)
                                            ->required(),
                                            
                                        DatePicker::make('published_at')
                                            ->label('Publish Date'),

                                        // TextInput::make('sort_order')
                                        //     ->required()
                                        //     ->numeric()
                                        //     ->default(0),
                                    ]),
                            ])
                            ->columnSpan(['lg' => 2]),
                    ])->columnSpanFull(),
                    
                Section::make('SEO Settings')
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description')
                            ->autosize()    
                            ->rows(1),
                        TagsInput::make('meta_keywords')
                            ->helperText('Comma separated keywords'),
                    ])
                    ->columns(2)
                    ->columnSpanFull()  
                    ->collapsed(),
            ]);
    }
}