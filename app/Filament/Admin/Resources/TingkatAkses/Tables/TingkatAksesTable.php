<?php

namespace App\Filament\Admin\Resources\TingkatAkses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TingkatAksesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('nama_tingkat')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Public' => 'success',
                    'Internal' => 'warning',
                    'Private' => 'danger',
                    default => 'gray',
                })
                ->searchable(),
            TextColumn::make('opd.nama_opd')
                ->label('Organisasi')
                ->sortable(),
        ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
