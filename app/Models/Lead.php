<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'motorcycle_of_interest_id',
        'assigned_to_user_id',
        'lead_origin_id',
        'status',
        'lost_reason',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function motorcycleOfInterest(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class, 'motorcycle_of_interest_id');
    }

    public function assignedToUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function leadOrigin(): BelongsTo
    {
        return $this->belongsTo(LeadOrigin::class);
    }
}


