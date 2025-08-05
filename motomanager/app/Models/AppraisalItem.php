<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TFactory
 * @extends Model<TFactory>
 */
class AppraisalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'appraisal_id',
        'item_description',
        'repair_cost',
        'notes',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'repair_cost' => 'decimal:2',
    ];

    public function appraisal(): BelongsTo
    {
        return $this->belongsTo(Appraisal::class);
    }
}


