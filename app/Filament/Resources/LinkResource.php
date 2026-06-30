<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Models\Link;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Override;


class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('original_url')
                    ->label('Оригинальный URL')
                    ->url()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('original_url')
                    ->label('Оригинальный URL')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('code')
                    ->label('Короткая ссылка')
                    ->formatStateUsing(fn (string $state) => url('/' . $state))
                    ->openUrlInNewTab()
                    ->color('primary'),

                TextColumn::make('clicks_count')
                    ->label('Кликов')
                    ->counts('clicks')
                    ->badge()
                    ->color('success'),
            ])
            ->actions([
                Action::make('view_stats')
                    ->label('Статистика')
                    ->icon('heroicon-o-chart-bar')
                    ->color('info')
                    ->url(fn (Link $record): string => LinkResource::getUrl('stats', ['record' => $record])),

                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'stats' => Pages\Stats::route('/{record}/stats'),
        ];
    }

    #[Override]
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }
}
