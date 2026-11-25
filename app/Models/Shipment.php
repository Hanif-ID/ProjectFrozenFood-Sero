<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'status',
        'estimated_arrival',
        'is_frozen_priority',
        'is_delayed',
        'temperature_note',
    ];

    protected $casts = [
        'estimated_arrival'  => 'datetime',
        'is_frozen_priority' => 'boolean',
        'is_delayed'         => 'boolean',
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}