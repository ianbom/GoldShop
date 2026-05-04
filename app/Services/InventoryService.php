<?php

namespace App\Services;

use App\Models\InventoryItem;
use App\Models\PurchaseItem;
use Illuminate\Support\Carbon;

class InventoryService
{
    public function __construct(private NumberGeneratorService $numbers) {}

    public function createFromPurchaseItem(PurchaseItem $item, Carbon|string $acquiredAt): InventoryItem
    {
        return InventoryItem::firstOrCreate(
            ['purchase_item_id' => $item->id],
            [
                'sku' => $this->numbers->sku(),
                'item_name' => $item->item_name,
                'item_type' => $item->item_type,
                'gold_carat' => $item->gold_carat,
                'weight_gram' => $item->weight_gram,
                'purchase_price' => $item->final_price,
                'selling_price' => $item->final_price,
                'status' => 'available',
                'condition' => $item->condition,
                'product_photo_url' => $item->product_photo_url,
                'acquired_at' => $acquiredAt,
            ]
        );
    }

    public function markSold(InventoryItem $item, Carbon|string $soldAt): void
    {
        abort_unless($item->status === 'available', 422, 'Inventory item not available.');
        $item->update(['status' => 'sold', 'sold_at' => $soldAt]);
    }

    public function restoreAvailable(InventoryItem $item): void
    {
        $item->update(['status' => 'available', 'sold_at' => null]);
    }
}
