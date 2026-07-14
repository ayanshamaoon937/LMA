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

class HomePage extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected string $view = 'filament.pages.home-page';

    protected static ?string $navigationLabel = 'Home';
    protected static ?int $navigationSort = 1;


    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'home')
            ->firstOrFail();

            
        $topBar = $page->section('top_bar');
        $hero = $page->section('hero');
        $who = $page->section('who_we_are');
        $what_we_do_services = $page->section('what_we_do_services');
        $projects = $page->section('what_we_do_projects');
        $upto_date_news = $page->section('upto_date_news');
        $video = $page->section('video');
        $sectors = $page->section('our_sectors');
        $map = $page->section('map');
        $contact = $page->section('contact');

        // $this->form->fill([
        //     'hero_title' => $hero?->title,
        //     'hero_subtitle' => $hero?->subtitle,
        //     'hero_content' => $hero?->content,
        //     'hero_image' => $hero?->image,

        //     'who_title' => $who?->title,
        //     'who_content' => $who?->content,
        //     'who_image' => $who?->image,

        //     'video_title' => $video?->title,
        //     'video_url' => $video?->content,

        //     'contact_title' => $contact?->title,
        //     'contact_phone' => $contact?->subtitle,
        //     'contact_email' => $contact?->button_text,
        //     'contact_content' => $contact?->content,

        //     'meta_title' => $page->meta_title,
        //     'meta_description' => $page->meta_description,
        // ]);

          $this->form->fill([
            'top_bar_address' => $topBar?->title,
            'top_bar_phone' => $topBar?->subtitle,
            'top_bar_email' => $topBar?->button_text,

            'hero_title' => $hero?->title,
            'hero_subtitle' => $hero?->subtitle,
            'hero_content' => $hero?->content,
            'hero_image' => $hero?->image,
            'hero_video' => $hero?->video,
            'hero_btn_text' => $hero?->button_text,

            'who_title' => $who?->title,
            'who_subtitle' => $who?->subtitle,
            'who_content' => $who?->content,
            'who_btn_text' => $who?->button_text,
            'who_image' => $who?->image,

            'what_we_do_title' => $what_we_do_services?->title,
            'what_we_do_subtitle' => $what_we_do_services?->subtitle,
            'what_we_do_content' => $what_we_do_services?->content,

            'projects_title' => $projects?->title,
            'projects_subtitle' => $projects?->subtitle,
            'projects_btn_text' => $projects?->button_text,

            'upto_date_news_title' => $upto_date_news?->title,
            'upto_date_news_subtitle' => $upto_date_news?->subtitle,

            'video_title' => $video?->title,
            'video_url' => $video?->content,
            'video_video' => $video?->video,
            'video_poster' => $video?->image,

            'sectors_title' => $sectors?->title,
            'sectors_content' => $sectors?->content,
            'sectors_image' => $sectors?->image,
            // meta is cast to array on PageSection, so ->meta is [] (not null)
            // even when no JSON has been saved yet — safe to index directly.
            'sectors_items' => $sectors?->meta['items'] ?? [],

            'map_center_lat' => $map?->meta['center_lat'] ?? 51.52,
            'map_center_lng' => $map?->meta['center_lng'] ?? -0.08,
            'map_zoom' => $map?->meta['zoom'] ?? 11,
            'map_locations' => $map?->meta['locations'] ?? [],

            'contact_title' => $contact?->title,
            'contact_subtitle' => $contact?->subtitle,
            // 'contact_phone' => $contact?->subtitle,
            // 'contact_email' => $contact?->button_text,
            'contact_content' => $contact?->content,

            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keywords' => json_decode($page->meta_keywords) ?? [],
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
             ->schema([
                Tabs::make('Homepage')
                    ->tabs([
                        // Tab::make('Top Bar')
                        //     ->icon('heroicon-o-bars-3-bottom-left')
                        //     ->schema([
                        //         Section::make()
                        //             ->description('This strip appears above the header on every page.')
                        //             ->schema([
                        //                 TextInput::make('top_bar_address')
                        //                     ->label('Address')
                        //                     ->placeholder('6th Floor, International House, 223 Regent Street, London W1B 2QD')
                        //                     ->columnSpanFull(),

                        //                 Grid::make(2)
                        //                     ->schema([
                        //                         TextInput::make('top_bar_phone')
                        //                             ->label('Phone Number')
                        //                             ->tel(),

                        //                         TextInput::make('top_bar_email')
                        //                             ->label('Email Address')
                        //                             ->email(),
                        //                     ]),
                        //             ]),
                        //     ]),

                        Tab::make('Hero')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->description('The large banner at the top of the homepage.')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Title')
                                            ->required()
                                            ->columnSpanFull(),

                                        // TextInput::make('hero_subtitle')
                                        //     ->label('Subtitle')
                                        //     ->columnSpanFull(),

                                        RichEditor::make('hero_content')
                                            ->label('Supporting Text')
                                            ->columnSpanFull(),

                                        TextInput::make('hero_btn_text')
                                            ->label('Button Text'),

                                        FileUpload::make('hero_image')
                                            ->label('Hero Image')
                                            ->image()
                                            ->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/home')
                                            ->columnSpanFull(),
                                        FileUpload::make('hero_video')
                                            ->label('Hero Video')
                                            ->directory('pages/home')
                                            ->disk('public')
                                            ->acceptedFileTypes([
                                                'video/mp4',
                                                'video/webm',
                                                'video/mpeg',
                                                'video/mov',
                                                'video/mkv',
                                            ])
                                            ->maxSize(100000)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Who We Are')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('who_title')
                                            ->label('Title')
                                            ->columnSpanFull(),

                                        TextInput::make('who_subtitle')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        RichEditor::make('who_content')
                                            ->label('Content')
                                            ->columnSpanFull(),

                                        TextInput::make('who_btn_text')
                                            ->label('Button Text'),
                                    ]),
                            ]),

                              Tab::make('Video')
                            ->icon('heroicon-o-play-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        FileUpload::make('video_video')
                                        ->label('Video File')
                                        ->disk('public')
                                        ->maxSize(10240)
                                        ->acceptedFileTypes(['video/mp4','video/mov','video/mkv','video/avi','video/webm'])
                                        ->directory('pages/home')
                                        ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('What We Do (Services)')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('what_we_do_title')
                                            ->label('Title')
                                            ->columnSpanFull(),

                                        TextInput::make('what_we_do_subtitle')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        RichEditor::make('what_we_do_content')
                                            ->label('Content')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('What We Do (Projects)')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('projects_title')
                                            ->label('Title')
                                            ->columnSpanFull(),

                                        TextInput::make('projects_subtitle')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        TextInput::make('projects_btn_text')
                                            ->label('Button Text'),
                                    ]),
                            ]),

                        Tab::make('Upto Date (News)')
                            ->icon('heroicon-o-newspaper')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('upto_date_news_title')
                                            ->label('Title')
                                            ->columnSpanFull(),

                                        TextInput::make('upto_date_news_subtitle')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        // TextInput::make('upto_date_news_btn_text')
                                        //     ->label('Button Text')
                                        //     ->required(),  
                                    ]),
                            ]),

                      

                        Tab::make('Our Sectors')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                Section::make()
                                    ->description('The heading, intro text and image for the "Our Sectors" section.')
                                    ->schema([
                                        TextInput::make('sectors_title')
                                            ->label('Heading')
                                            ->placeholder('OUR SECTORS')
                                            ->columnSpanFull(),

                                        RichEditor::make('sectors_content')
                                            ->label('Intro Text')
                                            ->columnSpanFull(),

                                        // FileUpload::make('sectors_image')
                                        //     ->label('Left-hand Image')
                                        //     ->image()
                                        //     ->disk('public')
                                        //     ->imageEditor()
                                        //     ->directory('pages/home')
                                        //     ->columnSpanFull(),
                                    ]),

                                Section::make('Sector Items')
                                    ->description('The icon list shown next to the intro text (e.g. Health & Education, Government, Commercial). Drag the handle to reorder.')
                                    ->schema([
                                        Repeater::make('sectors_items')
                                            ->label('')
                                            ->schema([
                                                // FileUpload::make('icon')
                                                //     ->label('Icon (SVG only)')
                                                //     ->directory('sectors/icons')
                                                //     ->acceptedFileTypes(['image/svg+xml'])
                                                //     ->helperText('Upload an .svg file, kept roughly square.'),

                                                 TextInput::make('icons')
                                                    ->label('Icon')
                                                    ->rules(['regex:/^bi bi-[a-zA-Z-]+$/'])
                                                    ->helperText('Use Bootstrap icon classes, e.g. bi bi-shield-check')
                                                    ->placeholder('e.g. bi bi-shield-check'),
                                                    // ->required(),

                                                FileUpload::make('image')
                                                    ->label('Section Image')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('sectors/images')
                                                    ->imageEditor()
                                                    ->helperText('The image that displays on the left when this item is active.'),

                                                TextInput::make('title')
                                                    ->label('Title')
                                                    ->placeholder('e.g. Health & Education')
                                                    ->required(),

                                                Textarea::make('description')
                                                    ->label('Description')
                                                    ->rows(3),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Sector')
                                            ->collapsible()
                                            ->addable(false)
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->addActionLabel('Add Sector')
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),


                            Tab::make('Map')
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Section::make('Map Settings')
                                    ->description('Controls where the homepage map is centred and how zoomed in it starts.')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('map_center_lat')
                                                    ->label('Center Latitude')
                                                    ->numeric()
                                                    ->step(0.0001)
                                                    ->required(),

                                                TextInput::make('map_center_lng')
                                                    ->label('Center Longitude')
                                                    ->numeric()
                                                    ->step(0.0001)
                                                    ->required(),

                                                TextInput::make('map_zoom')
                                                    ->label('Zoom Level')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->maxValue(20)
                                                    ->required()
                                                    ->helperText('Higher = more zoomed in. 11 is roughly all of London.'),
                                            ]),
                                    ]),

                                Section::make('Office / Site Locations')
                                    ->description('Each pin shown on the map. Add, remove, or drag to reorder. Label is optional — if set, it shows in a popup when the pin is clicked.')
                                    ->schema([
                                        Repeater::make('map_locations')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Label (optional)')
                                                    ->placeholder('e.g. London Office')
                                                    ->columnSpanFull(),

                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('lat')
                                                            ->label('Latitude')
                                                            ->numeric()
                                                            ->step(0.0001)
                                                            ->required(),

                                                        TextInput::make('lng')
                                                            ->label('Longitude')
                                                            ->numeric()
                                                            ->step(0.0001)
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Pin')
                                            ->collapsible()
                                            // ->reorderableWithButtons()
                                            ->reorderable(false)
                                            ->addActionLabel('Add Location')
                                            ->defaultItems(6)
                                            ->addable(false)
                                            ->deletable(false)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Contact')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Section::make()
                                    ->description('The "Get In Touch" section near the bottom of the homepage.')
                                    ->schema([
                                        TextInput::make('contact_title')
                                            ->label('Heading')
                                            ->columnSpanFull(),
                                        TextInput::make('contact_subtitle')
                                            ->label('Sub Title')
                                            ->columnSpanFull(),

                                        // Grid::make(2)
                                        //     ->schema([
                                        //         TextInput::make('contact_phone')
                                        //             ->label('Phone Number')
                                        //             ->tel(),

                                        //         TextInput::make('contact_email')
                                        //             ->label('Email Address')
                                        //             ->email(),
                                        //     ]),

                                        RichEditor::make('contact_content')
                                            ->label('Intro Text')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->helperText('Keep under ~60 characters so it doesn\'t get cut off in search results.')
                                            ->columnSpanFull(),

                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->maxLength(160)
                                            ->helperText('Keep under ~160 characters.')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        TagsInput::make('meta_keywords')
                                       ->helperText('Type Keywords and press Enter'),
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

            $page = Page::where('slug', 'home')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => $state['meta_keywords'] ?? null,
            ]);

            $sections = [
                'top_bar' => [
                    'title' => $state['top_bar_address'] ?? null,
                    'subtitle' => $state['top_bar_phone'] ?? null,
                    'button_text' => $state['top_bar_email'] ?? null,
                ],
                'hero' => [
                    'title' => $state['hero_title'] ?? null,
                    'subtitle' => $state['hero_subtitle'] ?? null,
                    'button_text' => $state['hero_btn_text'] ?? null,
                    'content' => $state['hero_content'] ?? null,
                    'image' => $state['hero_image'] ?? null,
                    'video' => $state['hero_video'] ?? null,
                ],
                'who_we_are' => [
                    'title' => $state['who_title'] ?? null,
                    'subtitle' => $state['who_subtitle'] ?? null,
                    'content' => $state['who_content'] ?? null,
                    'image' => $state['who_image'] ?? null,
                    'button_text' => $state['who_btn_text'] ?? null,
                ],
                'what_we_do_services' => [
                    'title' => $state['what_we_do_title'] ?? null,
                    'subtitle' => $state['what_we_do_subtitle'] ?? null,
                    'content' => $state['what_we_do_content'] ?? null,
                ],
                'what_we_do_projects' => [
                    'title' => $state['projects_title'] ?? null,
                    'subtitle' => $state['projects_subtitle'] ?? null,
                    'button_text' => $state['projects_btn_text'] ?? null,
                ],
                'upto_date_news' => [
                    'title' => $state['upto_date_news_title'] ?? null,
                    'subtitle' => $state['upto_date_news_subtitle'] ?? null,
                ],
                'video' => [
                    // 'title' => $state['video_title'] ?? null,
                    'video' => $state['video_video'] ?? null,
                    // 'content' => $state['video_url'] ?? null,
                    // 'image' => $state['video_poster'] ?? null,
                ],
                'our_sectors' => [
                    'title' => $state['sectors_title'] ?? null,
                    'content' => $state['sectors_content'] ?? null,
                    'image' => $state['sectors_image'] ?? null,
                    'meta' => [
                        'items' => $state['sectors_items'] ?? [],
                    ],
                ],

                 'map' => [
                    'meta' => [
                        'center_lat' => $state['map_center_lat'] ?? 51.52,
                        'center_lng' => $state['map_center_lng'] ?? -0.08,
                        'zoom' => $state['map_zoom'] ?? 11,
                        'locations' => $state['map_locations'] ?? [],
                    ],
                ],
                'contact' => [
                    'title' => $state['contact_title'] ?? null,
                    'subtitle' => $state['contact_subtitle'] ?? null,
                    // 'subtitle' => $state['contact_phone'] ?? null,
                    // 'button_text' => $state['contact_email'] ?? null,
                    'content' => $state['contact_content'] ?? null,
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
            ->title('Homepage updated')
            ->body('Your changes are now live.')
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