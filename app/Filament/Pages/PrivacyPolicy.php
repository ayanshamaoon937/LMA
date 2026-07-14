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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;

class PrivacyPolicy extends FilamentPage implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shield-check';
    protected static string|UnitEnum|null $navigationGroup = 'Content Management';
    protected static ?string $navigationLabel = 'Privacy Policy';
    protected string $view = 'filament.pages.privacy-policy';


    protected static ?int $navigationSort = 8;

    public ?array $data = [];

    public function mount(): void
    {
        $page = Page::with('sections')->where('slug', 'privacy-policy')->firstOrFail();
        
        $hero = $page->section('hero');
        $content = $page->section('content');

        $this->form->fill([
            // Hero Block Fields
            'hero_title' => $hero?->title ?? 'Privacy Policy',
            'hero_button_text' => $hero?->button_text ?? 'Get in touch with us',
            'hero_image' => $hero?->image,

            // Body Content
            'privacy_body' => $content?->content,

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
                Tabs::make('Privacy Policy Layout')
                    ->tabs([
                        Tab::make('Hero Banner')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Section::make([
                                    TextInput::make('hero_title')->label('Banner Title Header')->required(),
                                    TextInput::make('hero_button_text')->label('Action Button Label')->required(),
                                    FileUpload::make('hero_image')->label('Background Splash Image')->image()
->disk('public')->imageEditor()->directory('pages/legal'),
                                ]),
                            ]),

                        Tab::make('Page Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make([
                                    RichEditor::make('privacy_body')->label('Legal Policy Agreement Text')->columnSpanFull(),
                                ]),
                            ]),

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
            $page = Page::where('slug', 'privacy-policy')->firstOrFail();

            $page->update([
                'meta_title' => $state['meta_title'] ?? null,
                'meta_description' => $state['meta_description'] ?? null,
                'meta_keywords' => json_encode($state['meta_keywords']) ?? null,
            ]);

            // Save Hero Details
            $page->sections()->updateOrCreate(
                ['section_key' => 'hero'],
                [
                    'title' => $state['hero_title'],
                    'button_text' => $state['hero_button_text'],
                    'image' => $state['hero_image'] ?? null,
                ]
            );

            // Save Content Body
            $page->sections()->updateOrCreate(
                ['section_key' => 'content'],
                [
                    'title' => $state['hero_title'],
                    'content' => $state['privacy_body'],
                ]
            );
        });

        Notification::make()->success()->title('Privacy Policy layout updated.')->send();
    }

    protected function getHeaderActions(): array
    {
        return [Action::make('save')->label('Save Changes')->action('save')];
    }
}