<?php

namespace App\Filament\Resources\AdlRecordResource\Pages;

use App\Filament\Resources\AdlRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdlRecords extends ListRecords
{
    protected static string $resource = AdlRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
