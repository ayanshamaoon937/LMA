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

class News extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'News';
    protected string $view = 'filament.pages.news';

    protected static ?int $navigationSort = 6;

    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'news')
            ->firstOrFail();
            
        $hero = $page->section('hero');

        $this->form->fill([
            // Hero Banner Section Data (Now including the subtitle line)
            'hero_title' => $hero?->title ?? 'News',
            'hero_subtitle' => $hero?->subtitle ?? 'An inside look at our world',
            'hero_image' => $hero?->image,

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
                Tabs::make('News Page CMS')
                    ->tabs([
                        // --- TAB 1: HERO CONFIGURATION ---
                        Tab::make('Hero Header')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->description('Manage the top layout text blocks and banner images.')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Overlay Main Title Header')
                                            ->placeholder('News')
                                            ->required(),
                                        TextInput::make('hero_subtitle')
                                            ->label('Overlay Subtitle Tagline')
                                            ->placeholder('An inside look at our world')
                                            ->required(),
                                        FileUpload::make('hero_image')
                                            ->label('Background Splash Image')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/news')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 2: SEO CONFIGURATION ---
                        Tab::make('SEO Settings')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make([
                                    TextInput::make('meta_title')->label('Meta Title')->maxLength(60)->columnSpanFull(),
                                    Textarea::make('meta_description')->label('Meta Description')->maxLength(160)->rows(3)->columnSpanFull(),
                                    TagsInput::make('meta_keywords')->label('Meta Keywords Tracker'),
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
            $page = Page::where('slug', 'news')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            // Save Hero Section Content with both Title and Subtitle columns
            $page->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => $state['hero_title'],
                    'subtitle' => $state['hero_subtitle'],
                    'image' => $state['hero_image'] ?? null,
                ]
            );
        });

        Notification::make()->success()->title('News landing structure updated successfully.')->send();
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('save')->label('Save Changes')->action('save')];
    }
}