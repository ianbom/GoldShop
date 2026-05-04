<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['purchase_transaction_id', 'item_name', 'item_type', 'gold_carat', 'weight_gram', 'price_per_gram', 'estimated_price', 'deduction_amount', 'final_price', 'condition', 'description', 'product_photo_url'])]
class PurchaseItem extends Model
{
    use SoftDeletes;

    public function purchaseTransaction(): BelongsTo
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }

    public function inventoryItem(): HasOne
    {
        return $this->hasOne(InventoryItem::class);
    }
}
