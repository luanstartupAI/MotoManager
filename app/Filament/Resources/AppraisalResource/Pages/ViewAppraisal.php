<?php

namespace App\Filament\Resources\AppraisalResource\Pages;

use App\Filament\Resources\AppraisalResource;
use Filament\Resources\Pages\Page;

class ViewAppraisal extends Page
{
    protected static string $resource = AppraisalResource::class;

    protected static string $view = 'filament.resources.appraisal-resource.pages.view-appraisal';
}
