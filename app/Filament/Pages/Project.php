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
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;

class Project extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-folder-open';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected string $view = 'filament.pages.project';

    protected static ?int $navigationSort = 4;
    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'projects')
            ->firstOrFail();
            
        $intro = $page->section('intro');
        $card = $page->section('project_card');

        $this->form->fill([
            // Managing both layout action strings centrally
            'global_button_text' => $intro?->button_text ?? 'ALL PROJECTS',
            'global_title' => $intro?->title ?? '',
            'global_content' => $intro?->content ?? '',
            'card_button_text' => $card?->button_text ?? 'View Project',

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
                Tabs::make('Projects Page Framework')
                    ->tabs([
                        // --- TAB 1: GLOBAL BUTTON SETTINGS ---
                        Tab::make('Global Interface Strings')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make()
                                    ->description('Configure static button labels used globally across the portfolio grids.')
                                    ->schema([
                                        TextInput::make('global_button_text')
                                            ->label('Category Showcase Filter Button Text')
                                            ->placeholder('ALL PROJECTS')
                                            ->required(),
                                        TextInput::make('global_title')
                                            ->label('Title')
                                            ->placeholder('Category All Project Heading')
                                            ->required(),
                                        Textarea::make('global_content')
                                            ->label('Category All Project Description')
                                            ->placeholder('Category All Project Description')
                                            ->required(),
                                        TextInput::make('card_button_text')
                                            ->label('Project Thumbnail Card Hover Button Text')
                                            ->placeholder('View Project')
                                            ->required(),
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
            $page = Page::where('slug', 'projects')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            // Save filter selection button text
            $page->sections()->updateOrCreate(
                ['section_key' => 'intro'],
                [
                    'button_text' => $state['global_button_text'] ?? 'ALL PROJECTS',
                    'title' => $state['global_title'] ?? '',
                    'content' => $state['global_content'] ?? '',
                ]
            );

            // Save individual project item hover button text
            $page->sections()->updateOrCreate(
                ['section_key' => 'project_card'],
                [
                    'button_text' => $state['card_button_text'] ?? 'View Project',
                ]
            );
        });

        Notification::make()->success()->title('Projects Hub CMS labels synchronized.')->send();
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('save')->label('Save Changes')->action('save')];
    }
}