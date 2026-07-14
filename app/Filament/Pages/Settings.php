<?php

namespace App\Filament\Pages;

use App\Models\Setting;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Livewire\TemporaryUploadedFile;


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
use Filament\Forms\Components\Toggle;

use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use UnitEnum;
use BackedEnum;
use Filament\Pages\Page;

use Filament\Schemas\Schema;

use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Forms\Contracts\HasForms;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    // protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    // protected static ?string $navigationGroup = 'Settings';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

    protected  string $view = 'filament.pages.settings';


    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->loadSettings());
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action(fn () => $this->save()),
        ];
    }

    private function generalSection()
    {
        return Section::make('General Settings')
            ->schema([
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),

                TextInput::make('phone')
                    ->label('Phone Number'),

                // TextInput::make('whatsapp_number')
                //     ->label('WhatsApp Number'),

                // Toggle::make('add_noindex_to_all_pages')
                //     ->label('Add No Index Meta Tag')
                //     ->helperText('This will add noindex meta tag to all pages')
                //     ->default(false),
            ]);
    }
    private function GoogleTagManager()
    {
        return Section::make('Google Tag Manager')
            ->schema([
                 Textarea::make('google_tag_manager_link')
                            ->label('Google Tag Manager Website Head Tag Link')
                            ->rows(1)
                            ->autosize(),
                        Textarea::make('google_no_script_tag_manager_link')
                            ->label('Google Tag Manager Website after Body Tag No Script Tag Link')
                            ->rows(1)
                            ->autosize(),
            ]);
    }

    protected function save()
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {

            // JSON fields
            if (is_array($value)) {
                Setting::setJson($key, $value);
                continue;
            }

            // Normal values
            Setting::set($key, $value ?? '');
        }

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }



  
    public function form(Schema $form): Schema
    {
        return $form
            ->statePath('data')
            ->schema([
                Tabs::make('cms_tabs')
                    ->tabs([
                        Tabs\Tab::make('General')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                $this->generalSection(),
                                // $this->footerSection(),
                                // $this->ImagesSection(),
                                // $this->SocialLinksSection(),
                                // $this->GoogleTagManager(),
                            ]),
                        Tabs\Tab::make('Footer And TopBar Content')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                $this->footerSection(),
                            ]),
                        Tabs\Tab::make('Logos And Favicons')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                $this->ImagesSection(),
                            ]),
                        Tabs\Tab::make('Social Links And Google Tag Manager')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                $this->SocialLinksSection(),
                                $this->GoogleTagManager(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }


     private function ImagesSection()
    {
        return Section::make('Logo and favicons')
            ->schema([
                FileUpload::make('dark_logo')
                    ->label('Dark Logo')
                    ->directory('cms-images')
                    ->imageEditor()
                    ->acceptedFileTypes(['image/png','image/jpeg','image/jpg','image/webp'])
                    ->maxSize(1024)
                    ->image()
->disk('public'),
                FileUpload::make('white_logo')
                    ->label('White Logo')
                    ->directory('cms-images')
                    ->imageEditor()
                    ->acceptedFileTypes(['image/png','image/jpeg','image/jpg','image/webp'])
                    ->maxSize(1024)
                    ->image()
->disk('public'),
                FileUpload::make('favicon')
                    ->label('Favicon (96x96 PNG)')
                    ->directory('cms-images')
                    ->imageEditor()
                    ->acceptedFileTypes(['image/png'])
                    ->maxSize(1024)
                    ->image()
->disk('public'),
                FileUpload::make('favicon_svg')
                    ->label('Favicon (SVG)')
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->directory('cms-images')
                    ->maxSize(1024),
                FileUpload::make('favicon_ico')
                    ->label('Shortcut Icon (ICO)')
                    ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon', 'image/icon'])
                    ->directory('cms-images')
                    ->maxSize(1024),
                FileUpload::make('apple_touch_icon')
                    ->label('Apple Touch Icon (180x180 PNG)')
                    ->directory('cms-images')
                    ->acceptedFileTypes(['image/png'])
                    ->imageEditor()
                    ->maxSize(1024)
                    ->image()
->disk('public'),
                FileUpload::make('site_webmanifest')
                    ->label('Site Webmanifest (.webmanifest)')
                    ->acceptedFileTypes(['application/manifest+json', 'application/json', 'text/plain'])
                    ->directory('cms-images')
                    ->maxSize(1024),
            ])->columns(2);
    }

    private function footerSection()
    {
        return Section::make('Footer Section')
            ->schema([
                    TextInput::make('address')
                            ->label('Location Address')
                            ->maxLength(245),
                    Textarea::make('copyright_text')
                        ->rows(1)
                        ->label('Copyright Text')
                        ->autosize()
                        ->maxLength(1000),
                    TextInput::make('news_letter_title')
                            ->label('Newsletter Title')
                            ->maxLength(245),
                    Textarea::make('news_letter_description')
                            ->rows(1)
                            ->label('Newsletter Description')
                            ->autosize()
                            ->maxLength(1000),
                  
            ]);
    }


    private function SocialLinksSection()
    {
        return Section::make('Social Links')
            ->schema([
                  TextInput::make('facebook')
                            ->url()
                            ->prefix('https://') // Helpful UI prefix
                            ->maxLength(245),
                        TextInput::make('twitter')
                            ->url()
                            ->prefix('https://')
                            ->maxLength(245),
                        TextInput::make('instagram')
                            ->url()
                            ->prefix('https://')
                            ->maxLength(245),
                        TextInput::make('linkedin')
                            ->url()
                            ->prefix('https://')
                            ->maxLength(245),
            ]);
    }

    

    // 🔥 REUSABLE COMPONENTS

    private function translatableInput($key, $label)
    {
        return Tabs::make($key)
            ->tabs(
                collect($this->locales())->map(fn ($locale) =>
                    Tabs\Tab::make(strtoupper($locale))
                        ->schema([
                            TextInput::make("$key.$locale")
                                ->label($label)
                        ])
                )->toArray()
            );
    }

    private function translatableTextarea($key, $label)
    {
        return Tabs::make($key)
            ->tabs(
                collect($this->locales())->map(fn ($locale) =>
                    Tabs\Tab::make(strtoupper($locale))
                        ->schema([
                            Textarea::make("$key.$locale")
                            ->autosize()
                             ->rows(1)   
                            ->label($label)
                        ])
                )->toArray()
            );
    }

    private function locales()
    {
        return ['en', 'ar'];
    }

    private function loadSettings(): array
    {
        return Setting::pluck('value', 'key')
            ->map(function ($value, $key) {
                $decoded = json_decode($value, true);
                $result = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
                
                // Fix for broken image arrays
                if (in_array($key, ['logo', 'favicon', 'favicon_96x96', 'favicon_svg', 'favicon_ico', 'apple_touch_icon', 'site_webmanifest']) && is_array($result)) {
                    return null;
                }

                return $result;
            })
            ->toArray();
    }
}