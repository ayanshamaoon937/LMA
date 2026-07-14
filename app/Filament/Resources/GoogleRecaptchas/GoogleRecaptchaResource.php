<?php

namespace App\Filament\Resources\GoogleRecaptchas;

use App\Filament\Resources\GoogleRecaptchas\Pages\CreateGoogleRecaptcha;
use App\Filament\Resources\GoogleRecaptchas\Pages\EditGoogleRecaptcha;
use App\Filament\Resources\GoogleRecaptchas\Pages\ListGoogleRecaptchas;
use App\Filament\Resources\GoogleRecaptchas\Schemas\GoogleRecaptchaForm;
use App\Filament\Resources\GoogleRecaptchas\Tables\GoogleRecaptchasTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\GoogleRecaptcha;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class GoogleRecaptchaResource extends Resource
{
    protected static ?string $model = GoogleRecaptcha::class;

    protected static ?string $navigationLabel = 'Google Recaptcha';
    protected static string|UnitEnum |null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 5;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return GoogleRecaptchaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GoogleRecaptchasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return GoogleRecaptcha::count() === 0;
    }
    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGoogleRecaptchas::route('/'),
            'create' => CreateGoogleRecaptcha::route('/create'),
            'edit' => EditGoogleRecaptcha::route('/{record}/edit'),
        ];
    }
}
