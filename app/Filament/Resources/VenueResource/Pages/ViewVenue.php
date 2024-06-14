<?php

namespace App\Filament\Resources\VenueResource\Pages;

use App\Filament\Resources\VenueResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewVenue extends ViewRecord
{
    protected static string $resource = VenueResource::class;

    public function getTitle(): string | Htmlable
    {
        return $this->record->name;
    }

    public function getSubheading(): string | Htmlable | null
    {
        return $this->record->short_description;
    }
}
