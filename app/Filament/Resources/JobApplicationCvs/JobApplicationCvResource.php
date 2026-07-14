<?php

namespace App\Filament\Resources\JobApplicationCvs;

use App\Filament\Resources\JobApplicationCvs\Pages\CreateJobApplicationCv;
use App\Filament\Resources\JobApplicationCvs\Pages\EditJobApplicationCv;
use App\Filament\Resources\JobApplicationCvs\Pages\ListJobApplicationCvs;
use App\Filament\Resources\JobApplicationCvs\Pages\ViewJobApplicationCv;
use App\Filament\Resources\JobApplicationCvs\Schemas\JobApplicationCvForm;
use App\Filament\Resources\JobApplicationCvs\Tables\JobApplicationCvsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Models\JobApplicationCv;

class JobApplicationCvResource extends Resource
{
    protected static ?string $model = JobApplicationCv::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentArrowUp;

    public static function form(Schema $schema): Schema
    {
        return JobApplicationCvForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobApplicationCvsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobApplicationCvs::route('/'),
            'create' => CreateJobApplicationCv::route('/create'),
            'view' => ViewJobApplicationCv::route('/{record}'),
            'edit' => EditJobApplicationCv::route('/{record}/edit'),
        ];
    }
}
