<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VenueResource\Pages;
use App\Filament\Resources\VenueResource\RelationManagers;
use App\Models\Venue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class VenueResource extends Resource
{
    protected static ?string $model = Venue::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('wolt_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(300),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(300),
                Forms\Components\TextInput::make('short_description')
                    ->maxLength(1500),
                Forms\Components\TextInput::make('address')
                    ->maxLength(300),
                Forms\Components\TextInput::make('latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->numeric(),
                Forms\Components\TextInput::make('price_range')
                    ->numeric(),
                Forms\Components\TextInput::make('wolt_rating'),
                Forms\Components\Toggle::make('delivers')
                    ->required(),
                Forms\Components\FileUpload::make('image_url')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('wolt_id')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('short_description')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable()
                    ->hidden(),
                Tables\Columns\TextColumn::make('price_range')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('delivers')
                    ->boolean(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\RepeatableEntry::make('items')
                    ->schema([
                        Infolists\Components\ImageEntry::make('image_url')
                            ->hiddenLabel(),
                        Infolists\Components\TextEntry::make('name')
                            ->hiddenLabel()
                            ->size(TextEntrySize::Medium)
                            ->weight(FontWeight::SemiBold),
                        Infolists\Components\TextEntry::make('price')
                            ->money('EUR', 100)
                            ->inlineLabel()
                    ])
                    ->grid(3)
                    ->hiddenLabel()
                    ->contained(false),
            ])
            ->columns(1);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVenues::route('/'),
            'create' => Pages\CreateVenue::route('/create'),
            'view' => Pages\ViewVenue::route('/{record}'),
            'edit' => Pages\EditVenue::route('/{record}/edit'),
        ];
    }
}
