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
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document_number',
        'email',
        'phone_number',
        'address',
        'birth_date',
        'lead_origin_id',
        'assigned_to_user_id',
    ];

    /** @var array<string, string> */
    protected $casts = [
        'birth_date' => 'date',
    ];

    public function leadOrigin(): BelongsTo
    {
        return $this->belongsTo(LeadOrigin::class);
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }
}


