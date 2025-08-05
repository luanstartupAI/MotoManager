<?php

namespace App\Filament\Resources\LeadOriginResource\Pages;

use App\Filament\Resources\LeadOriginResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeadOrigin extends EditRecord
{
    protected static string $resource = LeadOriginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
