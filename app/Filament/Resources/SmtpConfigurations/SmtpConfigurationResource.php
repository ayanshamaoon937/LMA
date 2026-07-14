<?php

namespace App\Filament\Resources\SmtpConfigurations;

use App\Filament\Resources\SmtpConfigurations\Pages\CreateSmtpConfiguration;
use App\Filament\Resources\SmtpConfigurations\Pages\EditSmtpConfiguration;
use App\Filament\Resources\SmtpConfigurations\Pages\ListSmtpConfigurations;
use App\Filament\Resources\SmtpConfigurations\Schemas\SmtpConfigurationForm;
use App\Filament\Resources\SmtpConfigurations\Tables\SmtpConfigurationsTable;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\SmtpConfiguration;

class SmtpConfigurationResource extends Resource
{
    protected static ?string $model = SmtpConfiguration::class;
    protected static ?string $navigationLabel = 'SMTP Email Configuration';

    protected static string|UnitEnum |null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    public static function form(Schema $schema): Schema
    {
        return SmtpConfigurationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SmtpConfigurationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return SmtpConfiguration::count() === 0;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSmtpConfigurations::route('/'),
            'create' => CreateSmtpConfiguration::route('/create'),
            'edit' => EditSmtpConfiguration::route('/{record}/edit'),
        ];
    }
}
