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
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;

class Contact extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Contact';
    protected string $view = 'filament.pages.contact';

    protected static ?int $navigationSort = 7;

    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'contact')
            ->firstOrFail();
            
        $contact = $page->section('contact');
        $map = $page->section('map');

        // Extract JSON metadata nested fields safely
        $mapMeta = $map?->meta ?? [];

        $this->form->fill([
            // Contact Details Block
            'contact_title' => $contact?->title ?? 'Get In Touch',
            'contact_subtitle' => $contact?->subtitle ?? '',
            // 'contact_button_text' => $contact?->button_text ?? 'info@fcmltd.co.uk',
            'contact_content' => $contact?->content,

            // Map Configuration Block (Saved to meta schema)
            'center_lat' => $mapMeta['center_lat'] ?? 51.52,
            'center_lng' => $mapMeta['center_lng'] ?? -0.08,
            'zoom' => $mapMeta['zoom'] ?? 11,
            'locations' => $mapMeta['locations'] ?? [],

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
                Tabs::make('Contact Page CMS')
                    ->tabs([
                        // --- TAB 1: CONTACT LABELS ---
                        Tab::make('Contact Info')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('contact_title')->required(),
                                           TextInput::make('contact_subtitle')
                                            ->label('Sub Title')
                                            ->columnSpanFull(),
                                        // TextInput::make('contact_subtitle')->label('Phone Number Line')->required(),
                                        // TextInput::make('contact_subtitle')->label('Phone Number Line')->required(),
                                        // TextInput::make('contact_button_text')->label('Email Address Line')->required(),
                                        RichEditor::make('contact_content')->label('Intro Text')->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 2: INLINE MAP CONFIGURATION ---
                        Tab::make('Map Configuration')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Section::make('Map Focus Settings')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('center_lat')->label('Center Latitude')->numeric()->required(),
                                        TextInput::make('center_lng')->label('Center Longitude')->numeric()->required(),
                                        TextInput::make('zoom')->label('Map Zoom Level')->numeric()->required(),
                                    ]),

                                Section::make('Interactive Pin Coordinates')
                                    ->schema([
                                        Repeater::make('locations')
                                            ->label('Map Pins')
                                            ->columns(3)
                                            ->schema([
                                                TextInput::make('label')->placeholder('Optional Label/Name'),
                                                TextInput::make('lat')->label('Latitude')->numeric()->required(),
                                                TextInput::make('lng')->label('Longitude')->numeric()->required(),
                                            ])
                                            ->createItemButtonLabel('Add New Map Pin Location')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 3: SEO CONFIGURATION ---
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
            $page = Page::where('slug', 'contact')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            // 1. Save standard Contact content text parameters
            $page->sections()->updateOrCreate(
                ['section_key' => 'contact'],
                [
                    'title' => $state['contact_title'],
                    'subtitle' => $state['contact_subtitle'],
                    // 'button_text' => $state['contact_button_text'],
                    'content' => $state['contact_content'],
                ]
            );

            // 2. Wrap map arrays neatly directly into the component metadata JSON column
            $page->sections()->updateOrCreate(
                ['section_key' => 'map'],
                [
                    'meta' => [
                        'center_lat' => (float) $state['center_lat'],
                        'center_lng' => (float) $state['center_lng'],
                        'zoom' => (int) $state['zoom'],
                        'locations' => $state['locations'] ?? [],
                    ]
                ]
            );
        });

        Notification::make()->success()->title('Contact Page and Map configurations updated.')->send();
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('save')->label('Save Changes')->action('save')];
    }
}