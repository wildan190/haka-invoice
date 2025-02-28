<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['rental_id', 'invoice_number', 'invoice_date'];

    // Relasi ke Rental
    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    // Generate Nomor Invoice Format Indonesia (INV/YYYYMMDD/0001)
    public static function generateInvoiceNumber()
    {
        $tanggal = now()->format('Ymd'); // Format: YYYYMMDD
        $lastInvoice = self::whereDate('invoice_date', now())->orderBy('id', 'desc')->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return "INV/{$tanggal}/{$newNumber}";
    }
}
