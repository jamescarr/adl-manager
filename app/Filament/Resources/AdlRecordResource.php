<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdlRecordResource\Pages;
use App\Models\AdlRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AdlRecordResource extends Resource
{
    protected static ?string $model = AdlRecord::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('adl_type_id')
                    ->relationship('adlType', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'in_progress' => 'In Progress',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('recorded_at')
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->label('Duration (minutes)'),
                Forms\Components\Select::make('assistance_level')
                    ->options(AdlRecord::ASSISTANCE_LEVELS),
                Forms\Components\Select::make('mood')
                    ->options(AdlRecord::MOOD_OPTIONS),
                Forms\Components\TextInput::make('pain_level')
                    ->numeric()
                    ->min(0)
                    ->max(10),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('adlType.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'completed',
                        'warning' => 'in_progress',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('recorded_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'in_progress' => 'In Progress',
                        'cancelled' => 'Cancelled',
                    ]),
            ]);
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
            'index' => Pages\ListAdlRecords::route('/'),
            'create' => Pages\CreateAdlRecord::route('/create'),
            'edit' => Pages\EditAdlRecord::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('patient', function (Builder $query) {
                $query->whereHas('adlRecords', function (Builder $query) {
                    $query->where('created_by', auth()->id());
                });
            });
    }
}
