<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    protected $fillable = ['purchase_order_id', 'product_id', 'qty_ordered', 'specification'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}