<?php

namespace App\Filament\Resources\JobApplicationCvs\Pages;

use App\Filament\Resources\JobApplicationCvs\JobApplicationCvResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class ViewJobApplicationCv extends ViewRecord
{
    protected static string $resource = JobApplicationCvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download')
                ->label('Download CV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->url(fn () => Storage::disk('public')->url($this->record->file_path), shouldOpenInNewTab: true)
                ->visible(fn () => $this->record->file_path && Storage::disk('public')->exists($this->record->file_path)),
            DeleteAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('File Details')->schema([
                Grid::make(3)->schema([
                    TextEntry::make('filename')
                        ->label('Filename')
                        ->copyable()
                        ->placeholder('—'),

                    // TextEntry::make('mime_type')
                    //     ->label('MIME Type')
                    //     ->badge()
                    //     ->placeholder('—'),

                    // TextEntry::make('file_size')
                    //     ->label('File Size')
                    //     ->formatStateUsing(fn ($state) => $state ? round($state / 1024, 2) . ' KB' : '—'),

                    // TextEntry::make('is_temp')
                    //     ->label('Status')
                    //     ->badge()
                    //     ->formatStateUsing(fn (bool $state) => $state ? 'Temporary' : 'Permanent')
                    //     ->color(fn (bool $state) => $state ? 'warning' : 'success'),
                ]),
            ]),

            Section::make('Linked Application')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('jobApplication.first_name')
                            ->label('First Name')
                            ->placeholder('—'),

                        TextEntry::make('jobApplication.last_name')
                            ->label('Last Name')
                            ->placeholder('—'),

                        TextEntry::make('jobApplication.email')
                            ->label('Email')
                            ->copyable()
                            ->placeholder('—'),

                        TextEntry::make('jobApplication.phone')
                            ->label('Phone')
                            ->placeholder('—'),

                        TextEntry::make('jobApplication.job.title')
                            ->label('Position Applied')
                            ->placeholder('—'),
                    ]),

                    TextEntry::make('jobApplication.cover_letter')
                        ->label('Cover Letter')
                        ->prose()
                        ->columnSpanFull()
                        ->placeholder('No cover letter'),
                ])
                ->collapsible(),

            Section::make('Metadata')->schema([
                Grid::make(3)->schema([
                    TextEntry::make('created_at')
                        ->label('Uploaded At')
                        ->dateTime('d M Y H:i'),

                    TextEntry::make('updated_at')
                        ->label('Last Updated')
                        ->dateTime('d M Y H:i'),
                ]),
            ])->collapsible()->collapsed(),
        ]);
    }
}
