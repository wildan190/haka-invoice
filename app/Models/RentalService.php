<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalService extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'service_name',
        'service_price',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
