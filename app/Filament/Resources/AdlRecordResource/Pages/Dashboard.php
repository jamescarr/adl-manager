<?php

namespace App\Filament\Resources\AdlRecordResource\Pages;

use App\Filament\Resources\AdlRecordResource;
use Filament\Resources\Pages\Page;

class Dashboard extends Page
{
    protected static string $resource = AdlRecordResource::class;

    protected static string $view = 'filament.resources.adl-record-resource.pages.dashboard';
}
