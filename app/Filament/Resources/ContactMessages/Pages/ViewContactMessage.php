<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (is_null($this->record->read_at)) {
            $this->record->update(['read_at' => now()]);
        }
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Sender')->schema([
                Grid::make(3)->schema([
                    TextEntry::make('name')
                        ->label('Name')
                        ->placeholder('—'),

                    TextEntry::make('email')
                        ->label('Email')
                        ->copyable()
                        ->placeholder('—'),

                    TextEntry::make('user.name')
                        ->label('Registered User')
                        ->placeholder('Guest / anonymous'),
                ]),
            ]),

            Section::make('Message')->schema([
                TextEntry::make('subject')
                    ->label('Subject')
                    ->placeholder('—'),

                TextEntry::make('message')
                    ->label('Message')
                    ->prose()
                    ->columnSpanFull(),
            ]),

            Section::make('Metadata')->schema([
                Grid::make(3)->schema([
                    TextEntry::make('ip_address')
                        ->label('IP Address')
                        ->fontFamily('mono')
                        ->placeholder('—'),

                    TextEntry::make('read_at')
                        ->label('Read At')
                        ->dateTime('d M Y H:i')
                        ->placeholder('Unread'),

                    TextEntry::make('created_at')
                        ->label('Received At')
                        ->dateTime('d M Y H:i'),
                ]),
            ])->collapsible()->collapsed(),
        ]);
    }
}
