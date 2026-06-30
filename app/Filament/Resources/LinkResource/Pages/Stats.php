<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use App\Models\Link;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class Stats extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = LinkResource::class;
    protected static string $view = 'filament.resources.link-resource.pages.stats';

    public Link $record;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->record->clicks()->getQuery())
            ->columns([
                TextColumn::make('ip_address')
                    ->label('IP адрес пользователя')
                    ->fontFamily('mono'),
                TextColumn::make('created_at')
                    ->label('Дата/Время перехода')
                    ->dateTime('Y-m-d H:i:s'),
            ]);
    }
}
