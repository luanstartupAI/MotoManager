<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadOrigin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'lead_origin_id');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'lead_origin_id');
    }
}


