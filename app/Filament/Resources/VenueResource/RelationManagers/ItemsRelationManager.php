<?php

namespace App\Filament\Resources\VenueResource\RelationManagers;

use App\Filament\Resources\ItemResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function table(Table $table): Table
    {
        return ItemResource::table($table)
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('type', '!=', 'deal');
            });
    }
}
