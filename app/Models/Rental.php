<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
