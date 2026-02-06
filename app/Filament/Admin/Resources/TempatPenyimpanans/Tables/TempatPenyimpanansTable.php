<?php

namespace App\Filament\Admin\Resources\TempatPenyimpanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TempatPenyimpanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
           TextColumn::make('nama_ruangan')
                ->label('Ruangan')
                ->searchable(),
           TextColumn::make('posisi_lemari')
                ->label('Lemari'),
           TextColumn::make('posisi_rak')
                ->label('Rak'),
           TextColumn::make('baris')
                ->label('Baris'),
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
