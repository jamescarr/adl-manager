<?php

namespace App\Filament\Resources\AdlTypeResource\Pages;

use App\Filament\Resources\AdlTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdlTypes extends ListRecords
{
    protected static string $resource = AdlTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
