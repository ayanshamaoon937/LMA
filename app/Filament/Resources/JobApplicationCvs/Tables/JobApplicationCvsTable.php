<?php

namespace App\Filament\Resources\JobApplicationCvs\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Storage;

class JobApplicationCvsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('filename')
                    ->label('Filename')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('jobApplication.job.title')
                    ->label('Job Position')
                    ->limit(30)
                    ->searchable()
                    ->sortable(),

                // TextColumn::make('mime_type')
                //     ->label('Type')
                //     ->badge()
                //     ->toggleable(),

                // TextColumn::make('file_size')
                //     ->label('Size')
                //     ->formatStateUsing(fn ($state) => $state ? round($state / 1024, 2) . ' KB' : '-')
                //     ->sortable()
                //     ->toggleable(),

                // TextColumn::make('is_temp')
                //     ->label('Status')
                //     ->badge()
                //     ->formatStateUsing(fn (bool $state) => $state ? 'Temporary' : 'Permanent')
                //     ->color(fn (bool $state) => $state ? 'warning' : 'success')
                //     ->sortable(),

                TextColumn::make('jobApplication.first_name')
                    ->label('Applicant')
                    ->formatStateUsing(fn ($record) => $record->jobApplication
                        ? $record->jobApplication->first_name . ' ' . $record->jobApplication->last_name
                        : '-')
                    ->searchable(['first_name', 'last_name']),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('is_temp')
                    ->label('Status')
                    ->options([
                        '1' => 'Temporary',
                        '0' => 'Permanent',
                    ]),
            ])
            ->recordActions([
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(fn ($record) => Storage::disk('public')->url($record->file_path), shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->file_path && Storage::disk('public')->exists($record->file_path)),
                ViewAction::make(),
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
