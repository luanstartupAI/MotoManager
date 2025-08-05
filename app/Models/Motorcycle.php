<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Motorcycle extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'brand',
        'model',
        'version',
        'model_year',
        'manufacture_year',
        'type',
        'license_plate',
        'chassis_number',
        'renavam',
        'color',
        'mileage',
        'engine_details',
        'purchase_price',
        'refurbishment_cost',
        'sale_price',
        'status',
        'purchase_date',
        'details',
        'fipe_code',
    ];

    protected $casts = [
        'model_year' => 'integer',
        'manufacture_year' => 'integer',
        'mileage' => 'integer',
        'purchase_price' => 'decimal:2',
        'refurbishment_cost' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'purchase_date' => 'date',
    ];

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    public function appraisal(): HasOne
    {
        return $this->hasOne(Appraisal::class);
    }
}


