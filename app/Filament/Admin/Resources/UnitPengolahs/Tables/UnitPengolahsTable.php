<?php

namespace App\Filament\Admin\Resources\UnitPengolahs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UnitPengolahsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('nama_unit')
                ->label('Unit Pengolah')
                ->searchable()
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->label('Tanggal Input'),
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
