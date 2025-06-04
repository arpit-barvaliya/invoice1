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
        'amount',
        'description'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'rate' => 'decimal:2',
        'amount' => 'decimal:2'
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
