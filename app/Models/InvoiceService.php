<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceService extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'service_id',
        'quantity',
        'rate',
        'cgst_rate',
        'sgst_rate',
        'igst_rate',
        'discount',
        'scheme_amount',
        'basic_amount',
        'gst_amount',
        'total_amount'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'rate' => 'decimal:2',
        'cgst_rate' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'igst_rate' => 'decimal:2',
        'discount' => 'decimal:2',
        'scheme_amount' => 'decimal:2',
        'basic_amount' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
