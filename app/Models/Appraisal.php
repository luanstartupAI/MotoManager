<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @template TFactory
 * @extends Model<TFactory>
 */
class Appraisal extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorcycle_id',
        'appraiser_id',
        'base_fipe_price',
        'total_deductions',
        'final_appraisal_value',
        'appraisal_value',
        'status',
        'notes',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'base_fipe_price' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'final_appraisal_value' => 'decimal:2',
    ];

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function appraiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'appraiser_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(AppraisalItem::class);
    }

    public function appraisalItems(): HasMany
    {
        return $this->hasMany(AppraisalItem::class);
    }
}


