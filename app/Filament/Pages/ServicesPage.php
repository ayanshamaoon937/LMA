<?php

namespace App\Filament\Pages;

use App\Models\Page;
use Filament\Schemas\Schema;
use Filament\Pages\Page as FilamentPage;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;

class ServicesPage extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-briefcase';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected string $view = 'filament.pages.services-page';

    protected static ?string $navigationLabel = 'Services';

    protected static ?int $navigationSort = 3;

    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'services')
            ->firstOrFail();
            
        $hero = $page->section('hero');

        $this->form->fill([
            // Hero Banner Section
            'hero_title' => $hero?->title,
            'hero_image' => $hero?->image,
            'global_button_text' => $hero?->button_text ?? 'SEE MORE',

            // SEO Meta Elements
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keywords' => json_decode($page->meta_keywords) ?? [],
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Services Page CMS')
                    ->tabs([
                        // --- TAB 1: HERO CONFIGURATION ---
                        Tab::make('Hero Header')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->description('Manage the global landing hero elements for the services route.')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Overlay Text Header Title')
                                            ->placeholder('e.g., OUR SERVICES')
                                            ->required(),
                                        FileUpload::make('hero_image')
                                            ->label('Background Image Banner')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/services')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 2: GLOBAL SETTINGS ---
                        Tab::make('Global Component Labels')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make()
                                    ->description('Text layouts shared across dynamic services records.')
                                    ->schema([
                                        TextInput::make('global_button_text')
                                            ->label('Service Card Action Button Label')
                                            ->placeholder('SEE MORE')
                                            ->required(),
                                    ]),
                            ]),

                        // --- TAB 3: SEO ---
                        Tab::make('SEO Settings')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->columnSpanFull(),
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->maxLength(160)
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        TagsInput::make('meta_keywords')
                                            ->label('Meta Keywords Tracker'),
                                    ]),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        DB::transaction(function () {
            $state = $this->form->getState();

            $page = Page::where('slug', 'services')->firstOrFail();

            // Update Root Page Metadata
            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            // Save Hero Configuration
            $page->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => $state['hero_title'] ?? null,
                    'image' => $state['hero_image'] ?? null,
                    'button_text' => $state['global_button_text'] ?? 'SEE MORE',
                ]
            );
        });

        Notification::make()
            ->success()
            ->title('Services setup configured successfully.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Changes')
                ->action('save'),
        ];
    }
}