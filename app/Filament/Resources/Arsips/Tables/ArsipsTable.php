<?php

namespace App\Filament\Resources\Arsips\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Auth;

class ArsipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_file')->searchable(),
                TextColumn::make('kategori')->badge(),
                TextColumn::make('user.name')
                    ->label('Pengunggah')
                    ->visible(fn () => Auth::user()->role === 'admin'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
