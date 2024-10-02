<?php

namespace App\Filament\Resources\AdlRecordResource\Pages;

use App\Filament\Resources\AdlRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdlRecord extends EditRecord
{
    protected static string $resource = AdlRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
