<?php

namespace App\Filament\Resources\NewsArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;

use Filament\Tables\Filters\Indicator;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewsArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
        //  ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('image')
                     ->disk('public')
                    ->width(60)
                    ->height(60)
                    ->rounded(),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(60),

                TextColumn::make('slug')
                    ->searchable()
                    ->color('gray')
                    ->size('sm')
                    ->toggleable(isToggledHiddenByDefault: true),

                // TextColumn::make('published_at')
                //     ->label('Published')
                //     ->date('d M Y')
                //     ->sortable()
                //     ->badge()
                //     ->color('success'),

                ToggleColumn::make('is_active')
                    ->label('Published'),

                TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Published'),
                    // Published At Filter
                 Filter::make('published_at')
                    ->schema([
                        DatePicker::make('published_from'),
                        DatePicker::make('published_until'),
                    ])
                     ->indicateUsing(function (array $data): ?string {
                            if (! $data['published_from'] && ! $data['published_until']) {
                                return null;
                            }
                            if ($data['published_from'] && $data['published_until']) {
                                return 'Published at ' . Carbon::parse($data['published_from'])->toFormattedDateString() . ' to ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                            }
                            if ($data['published_from']) {
                                return 'Published at ' . Carbon::parse($data['published_from'])->toFormattedDateString();
                            }
                            if ($data['published_until']) {
                                return 'Published at ' . Carbon::parse($data['published_until'])->toFormattedDateString();
                            }
                        })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['published_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                            )
                            ->when(
                                $data['published_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}