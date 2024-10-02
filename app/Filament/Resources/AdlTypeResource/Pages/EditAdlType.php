<?php

namespace App\Filament\Resources\AdlTypeResource\Pages;

use App\Filament\Resources\AdlTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdlType extends EditRecord
{
    protected static string $resource = AdlTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
