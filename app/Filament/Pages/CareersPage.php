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
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;

class CareersPage extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-envelope';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Careers';
    protected static ?int $navigationSort = 5;


    protected string $view = 'filament.pages.careers-page';

    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')
            ->where('slug', 'careers')
            ->firstOrFail();

        $hero = $page->section('careers_hero');
        $whyJoin = $page->section('why_join');
        $positionsSection = $page->section('positions_section');
        $submitSection = $page->section('submit_applications');
        $life = $page->section('life_at_fcm');
        $benefits = $page->section('benefits');
        $process = $page->section('recruitment_process');
        $cta = $page->section('careers_cta');

        $this->form->fill([
            'hero_title' => $hero?->title,
            'hero_content' => $hero?->content,
            'hero_image' => $hero?->image,
            'hero_primary_btn_text' => $hero?->button_text,
            'hero_secondary_btn_text' => $hero?->meta['secondary_btn_text'] ?? null,

            'why_join_eyebrow' => $whyJoin?->subtitle,
            'why_join_title' => $whyJoin?->title,
            'why_join_items' => $whyJoin?->meta['items'] ?? [],

            'life_eyebrow' => $life?->subtitle,
            'life_title' => $life?->title,
            'life_images' => $life?->meta['images'] ?? [],

            'submit_application_title' => $submitSection?->title,
            'submit_application_sub_title' => $submitSection?->sub_title,
            'application_sidebar_items' => $submitSection?->meta['application_sidebar_items'] ?? [],

            'positions_title' => $positionsSection?->title,
            'positions_subtitle' => $positionsSection?->subtitle,
            'positions_global_button_text' => $positionsSection?->button_text,

            'benefits_title' => $benefits?->title,
            'benefits_items' => $benefits?->meta['items'] ?? [],

            'process_eyebrow' => $process?->subtitle,
            'process_title' => $process?->title,
            'process_steps' => $process?->meta['steps'] ?? [],

            'cta_title' => $cta?->title,
            'cta_content' => $cta?->content,
            'cta_btn_text' => $cta?->button_text,
            'cta_image' => $cta?->image,

            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Careers')
                    ->tabs([
                        Tab::make('Hero')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->description('The large banner at the top of the careers page.')
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Title')
                                            ->placeholder('Build Your Career With FCM')
                                            ->required()
                                            ->columnSpanFull(),

                                        RichEditor::make('hero_content')
                                            ->label('Supporting Text')
                                            ->columnSpanFull(),

                                        FileUpload::make('hero_image')
                                            ->label('Background Image')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/careers')
                                            ->columnSpanFull(),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('hero_primary_btn_text')
                                                    ->label('Primary Button Text')
                                                    ->placeholder('View Open Positions'),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('hero_secondary_btn_text')
                                                    ->label('Secondary Button Text')
                                                    ->placeholder('Submit Your CV'),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Why Join FCM')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('why_join_eyebrow')
                                            ->label('Eyebrow Text')
                                            ->placeholder('WHY JOIN FCM?')
                                            ->columnSpanFull(),

                                        TextInput::make('why_join_title')
                                            ->label('Heading')
                                            ->placeholder('More than just a job')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Feature Cards')
                                    ->description('The 4 cards (Challenging Projects, Career Growth, etc)')
                                    ->schema([
                                        Repeater::make('why_join_items')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('icons')
                                                    ->label('Icons Classes')
                                                    ->rules(['regex:/^bi bi-[a-zA-Z-]+$/'])
                                                    ->helperText('Use Bootstrap icon classes, e.g. bi bi-shield-check')
                                                    ->placeholder('e.g. bi bi-shield-check')
                                                    ->required(),

                                                TextInput::make('title')
                                                    ->label('Title')
                                                    ->placeholder('e.g. Challenging Projects')
                                                    ->required(),

                                                Textarea::make('description')
                                                    ->label('Description')
                                                    ->rows(2),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Card')
                                            ->collapsible()
                                            ->addable(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addActionLabel('Add Card')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Life at FCM')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('life_eyebrow')
                                            ->label('Eyebrow Text')
                                            ->placeholder('LIFE AT FCM')
                                            ->columnSpanFull(),

                                        TextInput::make('life_title')
                                            ->label('Heading')
                                            ->placeholder('Team. Culture. Impact.')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Gallery Images')
                                    ->description('The photo strip')
                                    ->schema([
                                        Repeater::make('life_images')
                                            ->label('')
                                            ->schema([
                                                FileUpload::make('image')
                                                    ->label('Image')
                                                    ->image()
->disk('public')
                                                    ->imageEditor()
                                                    ->directory('careers/life-at-fcm')
                                                    ->required(),

                                                TextInput::make('alt')
                                                    ->label('Alt Text (optional)')
                                                    ->helperText('Brief description for accessibility / SEO.'),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['alt'] ?? 'Gallery image')
                                            ->collapsible()
                                            ->reorderable(false)
                                            ->addable(false)
                                            ->deletable(false)
                                            // ->reorderableWithButtons()
                                            ->addActionLabel('Add Image')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Current Opportunities')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('positions_title')
                                            ->label('Title')
                                            ->columnSpanFull(),

                                        TextInput::make('positions_subtitle')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        TextInput::make('positions_global_button_text')
                                            ->label('Button text for all jobs')
                                            ->required(),
                                    ]),
                            ]),

                        Tab::make('Employee Benefits')
                            ->icon('heroicon-o-gift')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('benefits_title')
                                            ->label('Eyebrow Text')
                                            ->placeholder('EMPLOYEE BENEFITS')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Benefit Items')
                                    ->description('The icon strip (Competitive Salary, Flexible Working, etc)')
                                    ->schema([
                                        Repeater::make('benefits_items')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('icons')
                                                    ->label('Icons Classes')
                                                    ->rules(['regex:/^bi bi-[a-zA-Z-]+$/'])
                                                    ->helperText('Use Bootstrap icon classes, e.g. bi bi-shield-check')
                                                    ->placeholder('e.g. bi bi-shield-check')
                                                    ->required(),

                                                TextInput::make('label')
                                                    ->label('Label')
                                                    ->placeholder('e.g. Competitive Salary')
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'New Benefit')
                                            ->collapsible()
                                            ->addable(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addActionLabel('Add Benefit')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Submit Your Application')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('submit_application_title')
                                            ->label('Eyebrow Text')
                                            ->placeholder('APPLY TODAY')
                                            ->columnSpanFull(),

                                        TextInput::make('submit_application_sub_title')
                                            ->label('Heading')
                                            ->placeholder('Submit Your Application')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Form With Sidebar Items')
                                    ->description('The 3 cards Items')
                                    ->schema([
                                        Repeater::make('application_sidebar_items')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('icons')
                                                    ->label('Icons Classes')
                                                    ->rules(['regex:/^bi bi-[a-zA-Z-]+$/'])
                                                    ->helperText('Use Bootstrap icon classes, e.g. bi bi-shield-check')
                                                    ->placeholder('e.g. bi bi-shield-check')
                                                    ->required(),
                                                TextInput::make('title')
                                                    ->label('Title')
                                                    ->placeholder('e.g. Challenging Projects')
                                                    ->required(),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Card')
                                            ->collapsible()
                                            ->addable(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addActionLabel('Add Card')
                                            ->defaultItems(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Recruitment Process')
                            ->icon('heroicon-o-arrow-path')
                            ->schema([
                                Section::make()
                                    ->schema([
                                        TextInput::make('process_title')
                                            ->label('Eyebrow Text')
                                            ->placeholder('OUR RECRUITMENT PROCESS')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Process Steps')
                                    ->description('The numbered timeline (Submit Application, Initial Review, etc). Numbers are based on order, so just drag to reorder.')
                                    ->schema([
                                        Repeater::make('process_steps')
                                            ->label('')
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('Step Title')
                                                    ->placeholder('e.g. Submit Application')
                                                    ->required(),

                                                Textarea::make('description')
                                                    ->label('Description')
                                                    ->rows(2),
                                            ])
                                            ->columns(1)
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'New Step')
                                            ->collapsible()
                                            ->reorderableWithButtons()
                                            ->addActionLabel('Add Step')
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Closing Banner')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Section::make()
                                    ->description('The "Ready to Build Your Future With FCM?" banner near the bottom.')
                                    ->schema([
                                        TextInput::make('cta_title')
                                            ->label('Heading')
                                            ->columnSpanFull(),
                                        TextInput::make('cta_btn_text')
                                            ->label('Button Text')
                                            ->columnSpanFull(),

                                        RichEditor::make('cta_content')
                                            ->label('Supporting Text')
                                            ->columnSpanFull(),

                                        FileUpload::make('cta_image')
                                            ->label('Background Image')
                                            ->image()
->disk('public')
                                            ->imageEditor()
                                            ->directory('pages/careers')
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

            $page = Page::where('slug', 'careers')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
            ]);

            $sections = [
                'careers_hero' => [
                    'title' => $state['hero_title'] ?? null,
                    'content' => $state['hero_content'] ?? null,
                    'image' => $state['hero_image'] ?? null,
                    'button_text' => $state['hero_primary_btn_text'] ?? null,
                    'button_link' => '#current-opportunities',
                    'meta' => [
                        'secondary_btn_text' => $state['hero_secondary_btn_text'] ?? null,
                        'secondary_btn_link' => '#apply-today',
                    ],
                ],
                'why_join' => [
                    'subtitle' => $state['why_join_eyebrow'] ?? null,
                    'title' => $state['why_join_title'] ?? null,
                    'meta' => [
                        'items' => $state['why_join_items'] ?? [],
                    ],
                ],
                'positions_section' => [
                    'title' => $state['positions_title'] ?? null,
                    'subtitle' => $state['positions_subtitle'] ?? null,
                    'button_text' => $state['positions_global_button_text'] ?? null,
                ],
                'submit_applications' => [
                    'title' => $state['submit_application_title'] ?? null,
                    'subtitle' => $state['submit_application_sub_title'] ?? null,
                    'meta' => [
                        'application_sidebar_items' => $state['application_sidebar_items'] ?? [],
                    ],
                ],
                'life_at_fcm' => [
                    'subtitle' => $state['life_eyebrow'] ?? null,
                    'title' => $state['life_title'] ?? null,
                    'meta' => [
                        'images' => $state['life_images'] ?? [],
                    ],
                ],
                'benefits' => [
                    'title' => $state['benefits_title'] ?? null,
                    'meta' => [
                        'items' => $state['benefits_items'] ?? [],
                    ],
                ],
                'recruitment_process' => [
                    'subtitle' => $state['process_eyebrow'] ?? null,
                    'title' => $state['process_title'] ?? null,
                    'meta' => [
                        'steps' => $state['process_steps'] ?? [],
                    ],
                ],
                'careers_cta' => [
                    'title' => $state['cta_title'] ?? null,
                    'content' => $state['cta_content'] ?? null,
                    'button_text' => $state['cta_btn_text'] ?? null,
                    'image' => $state['cta_image'] ?? null,
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
            ->title('Careers page updated')
            ->body('Your changes are now live.')
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save changes')
                ->icon('heroicon-o-check')
                ->action('save'),
        ];
    }
}