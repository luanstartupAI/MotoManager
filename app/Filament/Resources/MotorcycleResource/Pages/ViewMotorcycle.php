<?php

namespace App\Filament\Resources\MotorcycleResource\Pages;

use App\Filament\Resources\MotorcycleResource;
use Filament\Resources\Pages\Page;

class ViewMotorcycle extends Page
{
    protected static string $resource = MotorcycleResource::class;

    protected static string $view = 'filament.resources.motorcycle-resource.pages.view-motorcycle';
}
