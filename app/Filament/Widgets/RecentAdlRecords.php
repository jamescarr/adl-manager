<?php

namespace App\Filament\Widgets;

use App\Models\AdlRecord;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;

class RecentAdlRecords extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AdlRecord::query()
                    ->where('created_by', auth()->id())
                    ->latest('recorded_at')
                    ->limit(5)
            )
            ->columns([
                TextColumn::make('patient.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('adlType.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'in_progress' => 'warning',
                        'cancelled' => 'danger',
                    }),
                TextColumn::make('recorded_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

    public static function makeFilamentTranslatableContentDriver(): Tables\Contracts\TranslatableContentDriver
    {
        return new Tables\SimpleTranslatableContentDriver();
    }
}
