<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['purchase_item_id', 'sku', 'item_name', 'item_type', 'gold_carat', 'weight_gram', 'purchase_price', 'selling_price', 'status', 'condition', 'product_photo_url', 'acquired_at', 'sold_at', 'notes'])]
class InventoryItem extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return ['acquired_at' => 'datetime', 'sold_at' => 'datetime'];
    }

    public function purchaseItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseItem::class);
    }

    public function salesItems(): HasMany
    {
        return $this->hasMany(SalesItem::class);
    }
}
