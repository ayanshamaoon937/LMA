<?php

namespace App\Filament\Pages;

use App\Models\Page;
use App\Models\PageSection;
use Filament\Schemas\Schema;
use Filament\Pages\Page as FilamentPage;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
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
use UnitEnum;

class About extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-information-circle';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected string $view = 'filament.pages.about';

    protected static ?int $navigationSort = 2;
    public ?array $data = [];

    public function mount(): void
    {
        // 1. Target the 'about' slug page instead of 'home'
        $page = Page::with('sections')
            ->where('slug', 'about') // or 'about-us' depending on your DB configuration
            ->firstOrFail();
            
        $hero = $page->section('hero');
        $established = $page->section('established');
        $what_we_do = $page->section('what_we_do');
        $help_banner = $page->section('help_banner');

        $this->form->fill([
            // Hero Banner Section
            'hero_title' => $hero?->title,
            'hero_image' => $hero?->image,

            // Established Section (Over 30 Years)
            'established_title' => $established?->title,
            'established_heading' => $established?->subtitle,
            'established_content' => $established?->content,
            'established_btn_text' => $established?->button_text,

            // Middle Image Breakdown
            'middle_break_image' => $page->section('middle_break')?->image,

            // What We Do Section (Let us be your eyes and ears)
            'what_we_do_title' => $what_we_do?->title,
            'what_we_do_heading' => $what_we_do?->subtitle,
            'what_we_do_content' => $what_we_do?->content,
            'what_we_do_items' => $what_we_do?->meta['items'] ?? [],

            // Lower Banner Image Breakdown
            'lower_break_image' => $page->section('lower_break')?->image,

            // We Are Here To Help Section
            'help_title' => $help_banner?->title,
            'help_content' => $help_banner?->content,

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
                Tabs::make('About Us Page')
                    ->tabs([
                        // --- TAB 1: HERO ---
                        Tab::make('Hero')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->description('The upper hero component of the About Us page.')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Overlay Text Title')
                                            ->placeholder('e.g., About Us')
                                            ->required(),
                                        FileUpload::make('hero_image')
                                            ->label('Background Image Banner')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/about')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 2: ESTABLISHED ---
                        Tab::make('Established Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make()
                                    ->description('Content block summarizing years active.')
                                    ->schema([
                                        TextInput::make('established_title')
                                            ->label('Small Subtitle Label')
                                            ->placeholder('WHO WE ARE'),
                                        TextInput::make('established_heading')
                                            ->label('Main Section Header Title')
                                            ->placeholder('Established for over 30 years'),
                                        RichEditor::make('established_content')
                                            ->label('Paragraph Summary Text')
                                            ->columnSpanFull(),
                                        // TextInput::make('established_btn_text')
                                        //     ->label('Hyperlink Button Anchor Text')
                                        //     ->placeholder('FCM Faculty Certificates'),
                                        FileUpload::make('middle_break_image')
                                            ->label('Separating Architectural Image Row (Below text blocks)')
                                            ->image()
->disk('public')
                                            ->directory('pages/about')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 3: WHAT WE DO ---
                        Tab::make('What We Do Checklist')
                            ->icon('heroicon-o-list-bullet')
                            ->schema([
                                Section::make()
                                    ->description('Provides items with specific graphical checkbox attributes.')
                                    ->schema([
                                        TextInput::make('what_we_do_title')
                                            ->label('Small Top Label')
                                            ->placeholder('WHAT WE DO'),
                                        TextInput::make('what_we_do_heading')
                                            ->label('Main Section Header Title')
                                            ->placeholder('Let us be your eyes and ears'),
                                        RichEditor::make('what_we_do_content')
                                            ->label('Introduction Paragraph Text')
                                            ->columnSpanFull(),
                                            
                                        Repeater::make('what_we_do_items')
                                            ->label('Checklist Items Array')
                                            ->schema([
                                                TextInput::make('list_string')
                                                    ->label('Row Text')
                                                    ->required(),
                                            ])
                                            ->addable(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['list_string'] ?? 'Checklist Item')
                                            ->columnSpanFull(),

                                        FileUpload::make('lower_break_image')
                                            ->label('Separating Site Image Row (Above contact prompt)')
                                            ->image()
->disk('public')
                                            ->directory('pages/about')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 4: HELP PROMPT ---
                        Tab::make('Help CTA Banner')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Section::make()
                                    ->description('Bottom Call to Action framework prompting inquiries.')
                                    ->schema([
                                        TextInput::make('help_title')
                                            ->label('Header Title Line')
                                            ->placeholder('We Are Here to Help'),
                                        RichEditor::make('help_content')
                                            ->label('Description Paragraph Framework')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        // --- TAB 5: SEO ---
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

            $page = Page::where('slug', 'about')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            $sections = [
                'hero' => [
                    'title' => $state['hero_title'] ?? null,
                    'image' => $state['hero_image'] ?? null,
                ],
                'established' => [
                    'title' => $state['established_title'] ?? null,
                    'subtitle' => $state['established_heading'] ?? null,
                    'content' => $state['established_content'] ?? null,
                    'button_text' => $state['established_btn_text'] ?? null,
                ],
                'middle_break' => [
                    'image' => $state['middle_break_image'] ?? null,
                ],
                'what_we_do' => [
                    'title' => $state['what_we_do_title'] ?? null,
                    'subtitle' => $state['what_we_do_heading'] ?? null,
                    'content' => $state['what_we_do_content'] ?? null,
                    'meta' => [
                        'items' => $state['what_we_do_items'] ?? [],
                    ],
                ],
                'lower_break' => [
                    'image' => $state['lower_break_image'] ?? null,
                ],
                'help_banner' => [
                    'title' => $state['help_title'] ?? null,
                    'content' => $state['help_content'] ?? null,
                ],
            ];

            foreach ($sections as $key => $data) {
                $page->sections()->updateOrCreate(
                    ['section_key' => $key],
                    $data
                );
            }
        });

        Notification::make()
            ->success()
            ->title('About Us page updated successfully.')
            ->body('Changes are now saved.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->action('save'),
        ];
    }
}