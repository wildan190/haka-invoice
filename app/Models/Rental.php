<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'mobil_id',
        'rental_type',
        'duration',
        'total_price',
        'use_dp',
        'dp_paid',
        'remaining_payment',
        'ppn',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function isLunas()
    {
        return $this->status === 'lunas';
    }

    public function services()
    {
        return $this->hasMany(RentalService::class);
    }

    public function invoice(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
