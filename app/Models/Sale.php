<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'motorcycle_id',
        'customer_id',
        'user_id',
        'final_sale_price',
        'sale_date',
        'payment_method',
        'trade_in_motorcycle_id',
        'notes',
    ];

    protected $casts = [
        'final_sale_price' => 'decimal:2',
        'sale_date' => 'date',
    ];

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tradeInMotorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class, 'trade_in_motorcycle_id');
    }
}


