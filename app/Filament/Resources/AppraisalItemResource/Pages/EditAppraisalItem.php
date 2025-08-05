<?php

namespace App\Filament\Resources\AppraisalItemResource\Pages;

use App\Filament\Resources\AppraisalItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAppraisalItem extends EditRecord
{
    protected static string $resource = AppraisalItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
